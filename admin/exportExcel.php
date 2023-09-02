<?php
require_once __DIR__ . "./../Technique/AutoLoad.php";
\Technique\AutoLoad::loadTFTT();

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$spreadsheet->removeSheetByIndex(0);

for ($i = 1; $i <= 14; $i++) {
    $sheet = $spreadsheet->createSheet();
    $lettre =  chr(64 + $i);
    $sheet->setTitle("Tableau$lettre");
    $colIndex = 1;
    $sql = "SELECT `numLicence`, `prenom`, `nom`, `nombrePoints`, `club` FROM `tableau{$lettre}` ORDER BY `numLicence` DESC";
    $result = \BDD\SGBD::getItemsInstance($sql,true);
    
    $headers = array_keys($result[0]);
    foreach ($headers as $columnIndex => $header) {
        $sheet->setCellValueByColumnAndRow($columnIndex + 1, 1, $header);
    }
    $rowIndex = 2; 
    foreach ($result as $data) {
        $colIndex = 1;
        foreach ($data as $value) {
            $sheet->setCellValueByColumnAndRow($colIndex, $rowIndex, $value);
            $colIndex++;
        }
        $rowIndex++; 
    }
}

$writer = new Xlsx($spreadsheet);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="test.xlsx"');
header('Cache-Control: max-age=0');

$writer->save('php://output');

exit;
?>