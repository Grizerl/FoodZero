## ADDED Requirements

### Requirement: Окрема точка входу для адмінки
Система SHALL збирати `resources/scss/admin.scss` у `public/assets/css/admin.css` тією самою командою `npm run scss:build`, використовувати спільні токени з `abstracts/` і не залежати від стилів публічного сайту.

#### Scenario: Збірка
- **WHEN** виконується `npm run scss:build`
- **THEN** створюється `public/assets/css/admin.css` з шапкою-коментарем про автогенерацію, а збірка завершується без помилок і попереджень

#### Scenario: Ізоляція
- **WHEN** аналізується `admin.css`
- **THEN** він не містить селекторів публічного сайту (`.banner-*`, `.dish-card`, `.post-card`) і не імпортує веб-шрифти Rufina/Lato
