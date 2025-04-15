<?php
include('../../../inc/includes.php');

$search = $_GET['searchText'] ?? '';

$results = [];
if ($search !== '') {
    $iterator = $DB->request([
        'FROM'   => 'glpi_tickets',
        'FIELDS' => ['id', 'name'],
        'WHERE'  => ['name' => ['LIKE', "%$search%"]],
        'LIMIT'  => 20
    ]);

    foreach ($iterator as $row) {
        $results[] = [
            'id'    => $row['id'],
            'label' => "Ticket #{$row['id']} - {$row['name']}"
        ];
    }
}

header('Content-Type: application/json');
echo json_encode(['results' => $results]);
