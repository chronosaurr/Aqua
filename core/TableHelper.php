<?php

class TableHelper {
    /**
     * @param array $headers Asocjacyjna tablica, gdzie klucz to pole w danych,
     * a wartość to nazwa nagłówka. Np. ['title' => 'Tytuł Ticketu']
     * @param array $dataRows Tablica z danymi do wyświetlenia. Każdy wiersz to
     * tablica asocjacyjna.
     * @param array $actions Tablica definiująca przyciski akcji dla każdego wiersza.
     * Każda akcja to tablica ['label' => '...', 'url' => '...', 'class' => '...']
     * URL może zawierać placeholder {id}, który zostanie zastąpiony ID wiersza.
     */
    public static function render(array $headers, array $dataRows, array $actions = []): void {
        echo '<table class="data-table">';

        // Renderowanie nagłówków
        echo '<thead><tr>';
        foreach ($headers as $header) {
            echo '<th>' . htmlspecialchars($header) . '</th>';
        }
        if (!empty($actions)) {
            echo '<th>Akcje</th>';
        }
        echo '</tr></thead>';

        // Renderowanie wierszy z danymi
        echo '<tbody>';
        if (empty($dataRows)) {
            $colSpan = count($headers) + (!empty($actions) ? 1 : 0);
            echo '<tr><td colspan="' . $colSpan . '">Brak danych do wyświetlenia.</td></tr>';
        } else {
            foreach ($dataRows as $row) {
                echo '<tr>';
                foreach (array_keys($headers) as $key) {
                    echo '<td>' . htmlspecialchars($row[$key] ?? '') . '</td>';
                }

                if (!empty($actions)) {
                    echo '<td class="actions">';
                    foreach ($actions as $action) {
                        $url = str_replace('{id}', $row['id'], $action['url']);
                        echo '<a href="' . htmlspecialchars($url) . '" class="btn ' . htmlspecialchars($action['class']) . '">' . htmlspecialchars($action['label']) . '</a> ';
                    }
                    echo '</td>';
                }
                echo '</tr>';
            }
        }
        echo '</tbody>';

        echo '</table>';
    }
}
