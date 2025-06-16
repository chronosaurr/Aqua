<?php

class TicketController extends BaseController {

    private Ticket $ticketModel;
    public function __construct() {
        $db = Database::getInstance();
        $this->ticketModel = new Ticket($db);
    }

    /**
     * Wyświetla listę wszystkich ticketów.
     */
    public function index(): void {
        $data = [
            'title' => 'Wszystkie Tickety',
            'activeController' => 'ticket'
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