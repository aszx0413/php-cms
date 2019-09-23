<?php

use League\Plates\Engine;
use PhpOffice\PhpSpreadsheet\IOFactory;

require_once 'init.php';

// --------------------------------------------------
// 获取项目
// --------------------------------------------------

if ($argc < 2) {
    die('Usage: php index.php <PROJECT_NAME> [<TABLE_NAME>]' . "\n");
} else {
    $project = $argv[1];
    $excelFile = dirname(__FILE__) . '/projects/' . $argv[1] . '.xlsx';
    if (!file_exists($excelFile)) {
        die('Excel 文件 ' . $argv[1] . " 不存在！\n");
    }
}

// --------------------------------------------------
// 获取实体
// --------------------------------------------------

try {
    $spreadsheet = IOFactory::load($excelFile);
    $rows = $spreadsheet->getActiveSheet()
        ->toArray(null, true, true, true);
} catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
    _e($e->getMessage());
} catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
    _e($e->getMessage());
}

$tables = [];

for ($i = 0; $i < count($rows); $i++) {
    $row = $rows[$i];

    if (is_null($row['B'])) {
        continue;
    }

    if ($row['B'] == 'Table') { // 表开始
        $table = [];
        $table['tableName'] = $row['C'];
        $table['tableNameCn'] = $row['D'];

        $i += 2;

        for (; $i < count($rows); $i++) {
            $row = $rows[$i];

            if (is_null($row['B'])) { // 表结束
                $tables[] = $table;
                break;
            } else { // 表字段
                $tbCol = [
                    'col'   => trim($row['B']),
                    'colCn' => trim($row['C']),
                    'type'  => trim($row['D']),
                    'len'   => trim($row['E']),
                    'key'   => trim($row['F']),
                    'form'  => trim($row['H']),
                    'list'  => trim($row['I']),
                ];
                $table['cols'][] = $tbCol;
            }
        }
    }
}

// --------------------------------------------------
// 生成模板
// --------------------------------------------------

foreach ($tables as $table) {
    $plate = new Engine(dirname(__FILE__));
    $plate->addData(['mark' => '?']);
    $html = $plate->render('form', $table);
    file_put_contents(dirname(__FILE__) . '/templates/' . $table['tableName'] . '_edit.html', $html);

    $plate = new Engine(dirname(__FILE__));
    $plate->addData(['mark' => '?']);
    $html = $plate->render('list', $table);
    file_put_contents(dirname(__FILE__) . '/templates/' . $table['tableName'] . '_list.html', $html);
}