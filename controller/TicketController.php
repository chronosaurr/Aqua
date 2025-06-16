<?php

class TicketController extends BaseController {

    private Ticket $ticketModel;
    public function __construct() {
        $db = Database::getInstance();
        $this->ticketModel = new Ticket($db);
    }

    /**
     * Domyślna akcja dla kontrolera. Jest to alias do metody list().
     *  Dzięki temu adres /ticket działa tak samo jak /ticket/list.
     */
    public function index(): void {
        $this->list();
    }

    /**
     * Wyświetla listę wszystkich ticketów.
     */
    public function list(): void {
        // dane testowe, aby zobaczyć, jak działa tabela
        $mockTickets = [
            ['id' => 1, 'title' => 'Problem z drukarką w dziale marketingu', 'status' => 'otwarty', 'priority' => 'wysoki'],
            ['id' => 2, 'title' => 'Brak dostępu do systemu CRM', 'status' => 'otwarty', 'priority' => 'średni'],
            ['id' => 3, 'title' => 'Wymiana myszki - zużyta', 'status' => 'zamknięty', 'priority' => 'niski'],
        ];
        $data = [
            'title' => 'Wszystkie Tickety',
            'activeController' => 'ticket',
            'tickets' => $mockTickets
        ];

        $this->renderView('ticket/list', $data);
    }

    /**
     * Wyświetla formularz do tworzenia nowego ticketu.
     */
    public function create(): void {
        $data = [
            'title' => 'Nowy Ticket',
            'activeController' => 'ticket'
        ];

        $this->renderView('ticket/create', $data);
    }
}