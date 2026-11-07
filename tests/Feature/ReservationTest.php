<?php

namespace Tests\Feature;

use App\Models\Reservation;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Tests hit the dev database, so they roll back (DatabaseTransactions) and live in
 * 2036, far from any real reservation. "Now" is Monday 2036-01-07 10:00.
 */
class ReservationTest extends TestCase
{
    use DatabaseTransactions;

    private const TUESDAY = '2036-01-08';

    private const SATURDAY = '2036-01-12';

    protected function setUp(): void
    {
        parent::setUp();

        $this->travelTo('2036-01-07 10:00:00');
        $this->withoutMiddleware([ThrottleRequests::class, ValidateCsrfToken::class]);
    }

    /**
     * @return array<string, string>
     */
    private function payload(array $overrides = []): array
    {
        return array_merge([
            'guest_name' => 'Test Guest',
            'reservation_date' => self::TUESDAY,
            'reservation_slot' => '18:00',
            'guest_count' => '2 Person',
        ], $overrides);
    }

    private function slot(array $response, string $time): array
    {
        return collect($response['slots'])->firstWhere('time', $time);
    }

    public function test_slots_come_from_the_fixed_list(): void
    {
        $response = $this->getJson(route('reservation.slots', ['date' => self::TUESDAY]))->assertOk();

        $this->assertSame(config('reservations.slots'), array_column($response['slots'], 'time'));
        $this->assertSame(self::TUESDAY, $response['date']);
        $this->assertTrue($response['slots'][0]['available']);
    }

    public function test_booked_slot_is_taken_only_on_its_own_date(): void
    {
        Reservation::create(['guest_name' => 'Taken', 'reservation_time' => self::TUESDAY.' 18:00:00', 'guest_count' => '2 Person']);

        $sameDay = $this->getJson(route('reservation.slots', ['date' => self::TUESDAY]))->json();
        $nextDay = $this->getJson(route('reservation.slots', ['date' => '2036-01-09']))->json();

        $this->assertFalse($this->slot($sameDay, '18:00')['available']);
        $this->assertTrue($this->slot($sameDay, '19:00')['available']);
        $this->assertTrue($this->slot($nextDay, '18:00')['available']);
    }

    public function test_slots_that_already_started_today_are_unavailable(): void
    {
        $this->travelTo('2036-01-07 15:20:00');

        $today = $this->getJson(route('reservation.slots', ['date' => '2036-01-07']))->json();

        foreach (['11:00', '13:00', '14:00', '15:00'] as $time) {
            $this->assertFalse($this->slot($today, $time)['available'], $time);
        }
        $this->assertTrue($this->slot($today, '16:00')['available']);
    }

    public function test_slots_endpoint_rejects_bad_dates(): void
    {
        foreach (['', 'tomorrow', '2036-02-30', '2036-01-06', self::SATURDAY, '2036-02-15'] as $date) {
            $this->getJson(route('reservation.slots', ['date' => $date]))
                ->assertStatus(422)
                ->assertJsonValidationErrors('date');
        }

        $this->getJson(route('reservation.slots'))->assertStatus(422);
    }

    public function test_reservation_is_created_and_answers_json(): void
    {
        $this->postJson(route('reservation.submit'), $this->payload())
            ->assertCreated()
            ->assertJson(['message' => 'Your reservation has been successfully added.']);

        $this->assertDatabaseHas('reservations', [
            'guest_name' => 'Test Guest',
            'reservation_time' => self::TUESDAY.' 18:00:00',
            'guest_count' => '2 Person',
        ]);
    }

    public function test_form_post_without_javascript_still_redirects(): void
    {
        $this->from(route('contact.page'))
            ->post(route('reservation.submit'), $this->payload())
            ->assertRedirect(route('contact.page'))
            ->assertSessionHas('success');
    }

    public function test_slot_outside_the_list_is_rejected(): void
    {
        $this->postJson(route('reservation.submit'), $this->payload(['reservation_slot' => '12:30']))
            ->assertStatus(422)
            ->assertJsonValidationErrors('reservation_slot');

        $this->assertDatabaseMissing('reservations', ['reservation_time' => self::TUESDAY.' 12:30:00']);
    }

    public function test_slot_in_the_past_is_rejected(): void
    {
        $this->travelTo('2036-01-07 15:20:00');

        $this->postJson(route('reservation.submit'), $this->payload(['reservation_date' => '2036-01-07', 'reservation_slot' => '11:00']))
            ->assertStatus(422)
            ->assertJsonValidationErrors('reservation_slot');
    }

    public function test_closed_day_and_far_future_are_rejected(): void
    {
        $this->postJson(route('reservation.submit'), $this->payload(['reservation_date' => self::SATURDAY]))
            ->assertStatus(422)
            ->assertJsonValidationErrors('reservation_date');

        $this->postJson(route('reservation.submit'), $this->payload(['reservation_date' => '2036-02-15']))
            ->assertStatus(422)
            ->assertJsonValidationErrors('reservation_date');
    }

    public function test_taken_slot_cannot_be_booked_twice(): void
    {
        $this->postJson(route('reservation.submit'), $this->payload())->assertCreated();

        $this->postJson(route('reservation.submit'), $this->payload(['guest_name' => 'Second Guest']))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['reservation_slot' => 'This time is already booked. Please choose another one.']);

        $this->assertSame(1, Reservation::where('reservation_time', self::TUESDAY.' 18:00:00')->count());
    }

    public function test_race_for_the_same_slot_gives_validation_error_not_500(): void
    {
        // Another guest takes the slot after validation passed but before our insert.
        Reservation::creating(function (): void {
            DB::table('reservations')->insert([
                'guest_name' => 'Faster Guest',
                'reservation_time' => self::TUESDAY.' 18:00:00',
                'guest_count' => '1 Person',
            ]);
        });

        $this->postJson(route('reservation.submit'), $this->payload())
            ->assertStatus(422)
            ->assertJsonValidationErrors(['reservation_slot' => 'This time is already booked. Please choose another one.']);

        $this->assertSame(1, Reservation::where('reservation_time', self::TUESDAY.' 18:00:00')->count());

        Reservation::flushEventListeners();
    }

    public function test_booking_form_pages_render_slots(): void
    {
        foreach (['home.page', 'menu.page', 'about.page', 'contact.page'] as $route) {
            $this->get(route($route))
                ->assertOk()
                ->assertSee('name="reservation_slot"', false)
                ->assertSee('name="reservation_date"', false);
        }
    }
}
