<?php

namespace GenDiff\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use function GenDiff\Src\Differ\genDiff;
use function GenDiff\Src\Formatters\Stylish\getStylish;
use function GenDiff\Src\Formatters\Plain\getPlain;
use function GenDiff\Src\Formatters\Json\getJson;

class GenDiffTest extends TestCase
{
    private $stylishDiff1;
    private $stylishDiff2;
    private $stylishDiff3;
    private $plainDiff4;
    private $jsonDiff5;

    protected function setUp(): void
    {
        $file1 = $this->getFixtureFullPath('file1.json');
        $file2 = $this->getFixtureFullPath('file2.json');
        $file3 = $this->getFixtureFullPath('file3.yaml');
        $file4 = $this->getFixtureFullPath('file4.yaml');
        $file5 = $this->getFixtureFullPath('file5.yaml');
        $file6 = $this->getFixtureFullPath('file6.yaml');

        $data1 = json_decode(file_get_contents($file1), true);
        $data2 = json_decode(file_get_contents($file2), true);
        $data3 = Yaml::parse(file_get_contents($file3));
        $data4 = Yaml::parse(file_get_contents($file4));
        $data5 = Yaml::parse(file_get_contents($file5));
        $data6 = Yaml::parse(file_get_contents($file6));

        $this->stylishDiff1 = getStylish(genDiff($data1, $data2));
        $this->stylishDiff2 = getStylish(genDiff($data3, $data4));
        $this->stylishDiff3 = getStylish(genDiff($data5, $data6));
        $this->plainDiff4 = getPlain(gendiff($data5, $data6));
        $this->jsonDiff5 = getJson(gendiff($data5, $data6));
    }

    private function getFixtureFullPath($fixtureName)
    {
        $file = [__DIR__, 'fixtures', $fixtureName];
        return realpath(implode('/', $file));
    }

   public function testStylishDiff1()
    {
        $expected = file_get_contents($this->getFixtureFullPath('expectedResult1'));
        $this->assertSame(trim($expected), trim($this->stylishDiff1));
    }
    public function testStylishDiff2()
    {
        $expected = file_get_contents($this->getFixtureFullPath('expectedResult2'));
        $this->assertSame(trim($expected), trim($this->stylishDiff2));
    }
    public function testStylishDiff3()
    {
        $expected = file_get_contents($this->getFixtureFullPath('expectedResult3'));
        $this->assertSame(trim($expected), trim($this->stylishDiff3));
    }
    public function testPlainDiff4()
    {
        $expected = file_get_contents($this->getFixtureFullPath('expectedResult4'));
        $this->assertSame(trim($expected), trim($this->plainDiff4));
    }
    public function testJsonDiff5()
    {
        $expected = file_get_contents($this->getFixtureFullPath('expectedResult5'));
        $this->assertSame(trim($expected), trim($this->jsonDiff5));
    }
}
