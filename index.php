<?php
/**
 * all happen from here
 */

@date_default_timezone_set("Asia/Shanghai");

// composer autoload
require_once 'vendor/autoload.php';

// echo
function _e($msg)
{
    echo ">>>>>";
    echo "\n";
    echo $msg;
    echo "\n";
    echo "<<<<<";
    echo "\n";
    die;
}

// debug
function aa($v)
{
    echo "\n";
    echo "<pre>";
    var_dump($v);
    echo "<pre>";
    echo "\n";
    die;
}
function bb($v)
{
    echo "\n";
    echo "<pre>";
    var_dump($v);
    echo "<pre>";
    echo "\n";
}

// excel absolute filepath
$excelFilePath = './demo.xlsx';

// sql filepath
$sqlFilePath = "./demo.sql";

// templates dir
$tplDir = "./tpl";

// tables
$tables = [];

// --------------------------------------------------
// Process excel

// load PHPExcel object
try {
    $phpexcel = PHPExcel_IOFactory::load($excelFilePath);
} catch (PHPExcel_Reader_Exception $e) {
    _e($e->getMessage());
}

// get first spreadsheet
$sheet = $phpexcel->getSheet(0);

// count rows
$cntRows = $sheet->getHighestDataRow();

// loop rows
for ($ri = 1; $ri <= $cntRows; $ri++) {
    // table start
    if ($sheet->getCell('B' . $ri)->getValue() == 'Table') {
        $table = [];

        $table['tableName'] = trim($sheet->getCell('C' . $ri)->getValue());
        $table['tableNameCn'] = trim($sheet->getCell('D' . $ri)->getValue());

        // skip the header rows
        $ri += 2;

        // loop attr rows
        for (; $ri <= $cntRows; $ri++) {

            // table end
            if ($sheet->getCell('B' . $ri)->getValue() == '') {
                $tables[] = $table;
                break;
            }

            $tbCol = [
                'col'   => trim($sheet->getCell('B' . $ri)->getValue()),
                'colCn' => trim($sheet->getCell('C' . $ri)->getValue()),
                'type'  => trim($sheet->getCell('D' . $ri)->getValue()),
                'len'   => trim($sheet->getCell('E' . $ri)->getValue()),
                'key'   => trim($sheet->getCell('F' . $ri)->getValue()),
            ];
            $table['cols'][] = $tbCol;
        }
    }
}

// finish processing excel
// --------------------------------------------------

// --------------------------------------------------
// process sql file

// sql str
$sql = '';

// loop tables
foreach ($tables as $tb) {
    $sql .= globalSql1($tb['tableName'], $tb['tableNameCn']);

    // loop cols
    foreach ($tb['cols'] as $col) {
        $sql .= colSql($col);
    }

    $sql .= globalSql2($tb['tableNameCn']);
}

file_put_contents($sqlFilePath, $sql);

/*
 * Create sql1
 */
function globalSql1($tb, $tbCn)
{
    $sql = '';

    // COMMENT
    $sql .= "# {$tbCn}" . "\n";

    // DROP TABLE
    $sql .= "DROP TABLE IF EXISTS `{$tb}`;" . "\n";

    // CREATE TABLE START
    $sql .= "CREATE TABLE `{$tb}` (" . "\n";
    $sql .= "\t" . "`id`          INT(10) NOT NULL AUTO_INCREMENT," . "\n";
    $sql .= "\t" . "`add_time`    DATETIME NOT NULL DEFAULT NOW()," . "\n";
    $sql .= "\t" . "`update_time` DATETIME NOT NULL DEFAULT '0'," . "\n";
    $sql .= "\t" . "`status`      TINYINT(1) NOT NULL DEFAULT 1," . "\n";
    $sql .= "\n";

    return $sql;
}

/*
 * Create sql col
 */
function colSql($col)
{
    $sql = '';

    // tab
    $sql .= "\t";

    // column name
    $sql .= str_pad("`{$col['col']}`", 18);

    // type and length
    if ($col['len']) {
        $sql .= ' ' . str_pad("{$col['type']}({$col['len']})", 13);
    } else {
        // DATETIME etc.
        $sql .= ' ' . str_pad("{$col['type']}", 13);
    }

    // NOT NULL
    $sql .= " NOT NULL";

    // DEFAULT
    // if there is INT, regardless INT/TINYINT/MEDIUMINT/BIGINT,
    // then it should be default 0
    if (strpos($col['type'], 'INT') !== false) {
        $sql .= " DEFAULT 0  ";
    } elseif ($col['type'] == 'VARCHAR' || $col['type'] == 'TEXT') {
        $sql .= " DEFAULT '' ";
    } elseif ($col['type'] == 'DATETIME') {
        $sql .= " DEFAULT '0'";
    }

    // COMMENT
    $sql .= " COMMENT '{$col['colCn']}'";

    $sql .= "," . "\n";

    return $sql;
}

/*
 * Create sql2
 */
function globalSql2($tbCn)
{
    $sql = "\n";

    // PRIMARY KEY
    $sql .= "\t" . "PRIMARY KEY(`id`)" . "\n";

    $sql .= ") ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_bin COMMENT '{$tbCn}';" . "\n\n";

    return $sql;
}

// finish processing sql file
// --------------------------------------------------
