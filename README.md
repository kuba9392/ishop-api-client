# Klient I-Shop REST Api

Biblioteka stworzona w celu ułatwienia komunikacji z API od I-Shop.

Aktualnie jest zaimplementowana obsługa encji Producentów. W razie potrzeby biblioteka została zaprojektowana w taki sposób,
aby kolejne zmiany były łatwe do wdrożenia.

## Testy
Testy integracyjne są uruchamiane z wykorzystaniem narzędzia Pact, która pozwala 
mockować żądania oraz odpowiedzi serwera HTTP. Gdy domyślny port **50000** jest zajęty, należy
wtedy podmienić zmienną środowiskową **MOCK_SERVER_PORT** na żądany numer portu.

Proces narzędzia Pact czasami ma tendencje do nie zamykania się. W tym wypadku port zostaje ciągle zajęty.
Należy wtedy usunąć ciągle chodzący proces ręcznie lub zmienić domyślnie ustawiony port.

## Przykłady użycia

### Instalacja
Przed uruchomieniem przykładów, jeśli biblioteka nie jest dociągnięta do innego projektu, należy uruchomić
proces instalacji zależności Composera.

```bash
composer install
```

W innym wypadku proces ten powinien uruchomić się przy zaciąganiu zależności w głównym projekcie.

### Konfiguracja
Aby prawidłowo uruchomić przykłady, należy w folderze **example** utworzyć plik .env w formacie podanym poniżej oraz 
uzupełnić wartości.

```dotenv
CLIENT_BASIC_AUTH_USER=<user>
CLIENT_BASIC_AUTH_PASSWORD=<password>
```

### Uruchamianie
Przykłady z zastosowaniem klienta można znaleźć w katalogu **example**.
Aby je uruchomić należy skorzystać z narzędzia **make** w głównym katalogu biblioteki. 

Aktualnie znajduje się tylko jeden przykład, który możemy uruchomić wykonując polecenie 
opisane poniżej.

```bash
make run_example SOURCE_ID=<source_id>
```

## Instrukcje

### Autoryzacja
Aby podać ustawić dane do autoryzacji, można skorzystać z domyślnie zaimplementowanej klasy **BasicAuthDataProvider**.

W przypadku zmiany sposobu autoryzacji, należy utworzyć swój Provider do danych autoryzacyjnych.