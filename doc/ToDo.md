# To-Do List: System Ticketowy

## Faza 0: Fundamenty i Szkielet Aplikacji (Gotowe)

- [x] Skonfigurowanie środowiska deweloperskiego (Docker Compose)
- [x] Stworzenie struktury bazy danych i tabel (`users`)
- [x] Przygotowanie pliku konfiguracyjnego (`config.php`)
- [x] Zdefiniowanie centralnej palety emoji i stałych
- [x] Implementacja prostego routera (`public/index.php`) opartego na `/{controller}/{method}/{params}`
- [x] Stworzenie bazowego kontrolera (`BaseController`) z metodą `renderView()`
- [x] Stworzenie placeholderów dla kontrolerów i widoków (`DashboardController`)
- [x] Przygotowanie modularnych części widoku (partials: `header`, `navbar`, `footer`)
- [x] Implementacja stopki z dynamicznymi statystykami (czas wykonania, wersja PHP, zużycie pamięci)
- [x] Stworzenie layoutu i stylizacji w CSS bez frameworków (z paletą kolorów w zmiennych)
- [x] Implementacja menu dropdown w CSS (`:hover`)
- [x] Implementacja podświetlania aktywnej zakładki w nawigacji

## Faza 1: System Uwierzytelniania i Użytkowników

- [x] **Implementacja logiki rejestracji**
  - [x] Stworzenie kontrolera `UserController`
  - [x] Stworzenie widoku `views/user/register.php`
  - [x] Dodanie metody `register()` w `UserController` do obsługi formularza
  - [x] Walidacja danych przychodzących z formularza (czy niepuste, czy email poprawny, czy hasła się zgadzają)
  - [x] Sprawdzenie, czy email lub nazwa użytkownika już nie istnieją w bazie
  - [x] Hashowanie hasła (`password_hash()`) i zapis nowego użytkownika do bazy
- [x] **Implementacja logiki logowania i sesji**
  - [x] Stworzenie widoku `views/user/login.php`
  - [x] Dodanie metody `login()` w `UserController`
  - [x] Weryfikacja danych i hasła (`password_verify()`)
  - [x] Zapisanie danych użytkownika w sesji (`$_SESSION`) po poprawnym logowaniu
  - [x] Wyświetlanie zalogowanego uzytkownika w stopce
  - [x] Zabezpieczenie stron/kontrolerów wymagających logowania
- [ ] **Implementacja resetowania hasła**
  - [ ] Formularz prośby o reset (wprowadzenie adresu e-mail)
  - [ ] Logika generowania bezpiecznego, jednorazowego tokenu i zapisywanie go w tabeli `password_resets`
  - [ ] Formularz do wprowadzenia nowego hasła (dostępny przez link z tokenem)
  - [ ] Logika weryfikacji tokenu i aktualizacji hasła w bazie danych
- [ ] **(Bonus) Weryfikacja adresu e-mail po rejestracji**
  - [ ] Generowanie tokenu weryfikacyjnego przy rejestracji
  - [ ] Logika sprawdzająca token i oznaczająca użytkownika jako zweryfikowanego

## Faza 2: Rdzeń Aplikacji - System Ticketów

- [x] **Stworzenie struktury dla Ticketów**
  - [x] Utworzenie w bazie tabel: `tickets`, `departments`, `comments`, `attachments`
  - [x] Stworzenie klas-modeli: `Ticket.php`, `Department.php`, `Comment.php`, `Attachment.php`
  - [x] Stworzenie kontrolera `TicketController.php`
  - [x] Stworzenie listy wydziałów
- [x] **Implementacja tworzenia ticketu (CRUD - Create)**
  - [x] Stworzenie widoku formularza `views/ticket/create.php`
  - [x] Metoda `create()` w `TicketController` do wyświetlania formularza
  - [x] Metoda `store()` w `TicketController` do obsługi danych z formularza
  - [x] Walidacja danych ticketu
  - [x] Logika obsługi przesyłania załącznika (`$_FILES`, `move_uploaded_file()`)
  - [x] Zapis informacji o tickecie i załączniku do odpowiednich tabel w bazie
- [x] **Implementacja wyświetlania ticketów (CRUD - Read)**
  - [x] Metoda `index()` w `TicketController` do wyświetlania listy wszystkich ticketów
  - [x] Widok `views/ticket/list.php` z tabelą ticketów
  - [x] Metoda `show($id)` w `TicketController` do wyświetlania pojedynczego ticketu
  - [x] Widok `views/ticket/show.php` ze szczegółami ticketu, listą komentarzy i załącznikami
- [x] **Implementacja edycji i zamykania ticketu (CRUD - Update)**
  - [x] Metoda `edit($id)` w `TicketController` do wyświetlania formularza edycji
  - [x] Widok `views/ticket/edit.php` z wypełnionymi danymi
  - [x] Metoda `update($id)` do zapisu zmian w bazie
  - [x] Przycisk i metoda do zmiany statusu na "zamknięty" i ustawienia `closed_at`
- [x] **Implementacja usuwania ticketu (CRUD - Delete)**
  - [x] Metoda `delete($id)` w `TicketController` do usuwania ticketu (i powiązanych komentarzy/załączników)
- [ ] **System Komentarzy**
  - [ ] Formularz dodawania komentarza pod widokiem ticketu
  - [ ] Metoda w `CommentController` lub `TicketController` do zapisu komentarza
  - [ ] Wyświetlanie komentarzy na stronie ticketu

## Faza 3: Panel Administracyjny i Role

- [x] **Implementacja logiki ról i uprawnień**
  - [x] Rozbudowa klasy `Auth` o metody sprawdzające role (np. `isAdmin()`, `isOwner()`)
  - [x] Zabezpieczanie metod w kontrolerach w oparciu o role
- [x] **Panel Administratora (`AdminController`)**
  - [x] Widok panelu `views/admin/dashboard.php`
  - [x] Zarządzanie użytkownikami (CRUD)
    - [x] Lista użytkowników
    - [x] Możliwość zmiany roli, edycji danych
  - [x] Zarządzanie działami (CRUD)
    - [x] Lista działów
    - [x] Formularze dodawania/edycji działów
- [ ] **Funkcjonalności dla Właściciela Działu (rola 'owner')**
  - [ ] Możliwość edycji/usuwania ticketów tylko w swoim dziale
  - [ ] Możliwość przypisywania osób do zadań w swoim dziale

## Faza 4: Widoki i Filtrowanie

- [ ] **Implementacja różnych widoków listy ticketów**
  - [ ] Widok "Moje zadania" (przypisane do zalogowanego użytkownika)
  - [ ] Widok "Zadania per dział"
  - [ ] Widok "Backlog" (niezamknięte zadania z danym priorytetem)
- [ ] **Prosty Kalendarz**
  - [ ] Widok zadań na konkretny dzień (na podstawie `deadline_at`)
  - [ ] (Bonus) Widok w formie siatki kalendarza na cały miesiąc

## Faza 5: Finalizacja i Wdrożenie

- [ ] **Testowanie i poprawki**
  - [ ] Przejrzenie wszystkich funkcjonalności
  - [ ] Sprawdzenie obsługi błędów (np. próba dostępu bez uprawnień)
  - [ ] Upewnienie się, że nie ma widocznych błędów PHP
- [ ] **Przejrzystość kodu i repozytorium**
  - [ ] Refaktoryzacja i upewnienie się, że kod jest czytelny
  - [ ] Uporządkowanie commitów w repozytorium Git
- [ ] **Wdrożenie na serwerze**
  - [ ] Przygotowanie do wdrożenia na serwerze uczelnianym/zewnętrznym
  - [ ] Konfiguracja bazy danych na serwerze produkcyjnym