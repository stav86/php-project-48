<?php

namespace GenDiff\Src\Parse;

function parseJsonFile($filePath)
{
    $fileContent = file_get_contents($filePath);
    $data = json_decode($fileContent, true);
    return $data;
}
