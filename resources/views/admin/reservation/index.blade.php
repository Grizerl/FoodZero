@extends('layouts.admin')

@section('content')
   <section>
      @if(session('success'))
         <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&#10006;</button>
               <h4><i class="icon fa fa-check"></i>{{session('success')}}</h4>
         </div>
      @endif
      <div class="card">
         <div class="card-header">
            <h3 class="card-title">Reservation items</h3>
            <div class="card-tools">
               <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
               </button>
               <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                  <i class="fas fa-times"></i>
               </button>
            </div>
         </div>
         <div class="card-body p-0">
            <table class="table table-striped projects">
               <thead>
                  <tr>
                     <th style="width: 1%">
                        ID
                     </th>
                     <th style="width: 20%">
                        Reservation Name
                     </th>
                     <th style="width: 8%" class="text-center">
                        Reservation Time
                     </th>
                     <th style="width: 10%">
                        Guest Count
                     </th>
                  </tr>
               </thead>
               <tbody>
                    @foreach ($reserv as $reservation)
                     <tr>
                        <td>
                          {{ $reservation->id }}
                        </td>
                        <td>
                            {{ $reservation->guest_name}}
                        </td>
                        <td class="project-state" style="width: 60%;">
                            {{ $reservation->reservation_time}}
                        </td>
                        <td class="project-state" style="width: 50%; text-align: left;">
                            {{ $reservation->guest_count}}
                        </td>
                        <td class="project-actions text-right" style="display: inline-flex;">
                           <form action="{{ route('reservation.destroy',$reservation->id) }}" method="post">
                              @csrf
                                 @method('DELETE')
                                 <button type="submit" class="btn btn-danger btn-sm delete-btn">
                                    <i class="fas fa-trash"></i>
                                    Remove
                                 </button>
                           </form>
                        </td>
                     </tr>
                     @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </section>
@endsection