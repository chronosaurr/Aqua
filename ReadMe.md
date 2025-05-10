# System ticketowy a'la Jira
System ticketowy pozwala na dodawanie ticketów wraz z opcjonalnymi załącznikami. Każdy ticket składa się z tytułu, priorytetu, działu obsługi, 
osoby wyznaczonej do wykonania zadania (domyślnie pusty), opcjonalnego załącznika, daty dodania, daty zamknięcia, która będzie dodawać się automatycznie po odznaczeniu, 
że dany ticket został rozwiązany oraz daty deadline, czyli daty, do której ticket powinien zostać wykonany. Strona oferuje możliwość przeglądania zadań 
dla danego użytkownika z prostym kalendarzem, zdań per dział, niezamkniętych zadań z danym priorytetem (backlog) oraz przeglądania zadań na konkretny dzień. 
Każdy użytkownik ma możliwość sprawdzenia swojej listy zadań i oznaczenia, czy dane zadanie zostało zakończone. Do wystawienia ticketu wymagane jest zalogowanie, 
natomiast niezalogowani użytkownicy mogą sprawdzać zadania dodane w każdym dziale. Zalogowani użytkownicy mają możliwość dodawania komentarzy do ticketów oraz mają 
możliwość oznaczania, że ticket został wykonany. Na stronie dostępny jest panel administracyjny. Istnieją różne typy konta: administrator 
(może wszystko - dodawać, usuwać, edytować tickety, komentarze i działy), właściciel działu (może dodawać, usuwać i edytować tickety ze swojego działu,
może dodawać komentarze i przypisywać osoby, może zresetować swoje hasło), użytkownik (może dodawać tickety i komentarze, może rozwiązywać swoje tickety oraz może zresetować swoje hasło).
Tickety, komentarze i informacje o użytkownikach powinny być przechowywane w bazie danych, a załączniki jako osobne pliki.



## Ogólne założenia projektów:
- Projekt nie ma progu zaliczenia, chociaż stanowi 50% oceny. Jeśli ktoś uważa, że zaliczy przedmiot poprzez laboratoria i kolokwium, nie musi realizować projektu.
- Projekt realizuje każdy osobno w PHP bez użycia framework’ów.
- Temat projektu wraz z opisem powinien znaleźć się w Excelu z repozytoriami w osobnym arkuszu (do czasu oddania projektu).
- Projekt oddajemy na dowolnych zajęciach, oprócz przedostatnich (kolokwium). Ostateczny termin oddania projektów to ostatnie zajęcia.
- W dniu oddawania projekt powinien działać i być zdatny do sprawdzenia.
- Każdy będzie miał 10 minut na prezentację (po 5 minut na prezentację wizualną i funkcjonalności oraz prezentację kodu + ewentualne pytania do kodu i delikatne zmiany w kodzie).

Wymagania projektu podane niżej. Można wybrać to, co się realizuje z wymagań, kosztem nie uzyskania punktów za pozostałe wymagania.
Wymagania z oznaczeniem (dodatkowo) nie są obowiązkowe i nie stanowią podstawowej części punktacji (są ponad próg). 
Można zamienić wymaganie podstawowe na wymaganie dodatkowe, jednak jeśli podstawowe wymaganie jest na 2 pkt., a dodatkowe na 1 pkt., to otrzymać można 1 pkt, w odwrotnej korelacji podstawowe 1 pkt., dodatkowe 2pkt., również otrzyma się 1 pkt.
Za dodatkowe zadania można uzyskać ograniczoną ilość punktów, nawet jeśli zrealizuje się więcej dodatkowych zadań. Chyba, że realizacja zadania dodatkowego służy “wymianie” za podstawowe.
W razie pytań, czy konsultacji zapraszam do kontaktu mailowego.
Jeśli projekt rozwiązuje rzeczywisty problem i jest mocno zaawansowany, to jest możliwość uzyskania dodatkowych punktów - mocno uznaniowe punkty.

## Wymagania ogólne (funkcjonalne, wizualne i techniczne):
- użycie formularzy i ich funkcjonalności - odbieranie i przetwarzanie danych
- zapisywanie do pliku danych - np. zrzut bazy danych, zapis danych z formularza, zapis przesłanych plików itp.
- zapisywanie do bazy danych (mysql)
- odczytywanie z bazy danych
- aktualizowanie i usuwanie z bazy danych
- prosty system logowania z weryfikacją adresu e-mail
- użycie sesji w projekcie, nie sztuczne, tylko takie by pozwalało realnie zobrazować ich funkcjonalność
- użycie ciasteczek - utworzenie oraz realne skorzystanie z nich
- użycie pętli, instrukcje warunkowe, tablice, funkcji
- obsługa obrazów na stronie (upload na serwer)
- prosty system zarządzania stroną (panel administratora)
- różne role (niezalogowany, zalogowany, admin) + resetowanie hasła
- użycie programowania obiektowego - logiczny podział na klasy
- użycie różnych selektorów CSS (ID, klasy, pseudoklasy)
- stylizacja tekstu - rozmiar czcionki, kolor itd.
- użycie flexboxów i CSS grid
- (dodatkowo) użycie czegoś zaawansowanego z PHP, co nie było pokazywane na zajęciach - biblioteka, narzędzie, konstrukcja, temat (wymagane omówienie)
- (dodatkowo) użycie czegoś, co nie było pokazywane na zajęciach (dodatkowy język, skrypty) - biblioteka, narzędzie, konstrukcja, temat (wymagane krótkie omówienie)
- hostowanie strony na uczelnianym serwerze
- (dodatkowo) hostowanie na zewnętrznym serwerze


## Wymagania niefunkcjonalne:
- Przejrzysty kod - np. rozbicie na pliki, klasy, metody, stosowanie pętli zamiast printowania na sztywno
- Brak widocznych błędów komunikowanych przez PHP
- Projekt się “kompiluje” - brak problemów przy oddawaniu projektu
- Repozytorium - commity, porządek etc.

Każdy projekt ma również założenia co do funkcjonalności projektu, które zdefiniowane są w opisie danego projektu. Funkcjonalności można zmieniać i modyfikować po uprzednim kontakcie z prowadzącym.
