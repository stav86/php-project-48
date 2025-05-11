<?php

namespace GenDiff\Tests;

use PHPUnit\Framework\TestCase;
use function GenDiff\Src\Differ\genDiff;

class GenDiffTest extends TestCase
{
    private $genDiff;

    protected function setUp(): void
    {
        $file1 = $this->getFixtureFullPath('file1.json');
        $file2 = $this->getFixtureFullPath('file2.json');

        $data1 = json_decode(file_get_contents($file1), true);
        $data2 = json_decode(file_get_contents($file2), true);

        $this->genDiff = genDiff($data1, $data2);
    }
    private function getFixtureFullPath($fixtureName)
    {
        $file = [__DIR__, 'fixtures', $fixtureName];
        return realpath(implode('/', $file));
    }

    public function testGenDiff1()
    {
        $expected = "- follow: false\n  host: hexlet.io\n- proxy: 123.234.53.22\n- timeout: 50\n+ timeout: 20\n+ verbose: true\n";
        $this->assertEquals($expected, $this->genDiff);
    }
}