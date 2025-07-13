<?php

namespace GenDiff\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use InvalidArgumentException;

use function Differ\Differ\genDiff;
use function GenDiff\Src\Formatters\{
    Stylish\getStylish,
    Plain\getPlain,
    Json\getJson,
};
use function GenDiff\Src\Parsers\{
    parseData,
    parseJson,
    parseYaml,
};

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

        $this->stylishDiff1 = genDiff($file1, $file2);
        $this->stylishDiff2 = genDiff($file3, $file4);
        $this->stylishDiff3 = genDiff($file5, $file6, 'stylish');
        $this->plainDiff4 = genDiff($file5, $file6, 'plain');
        $this->jsonDiff5 = genDiff($file5, $file6, 'json');
    }

    private function getFixtureFullPath($fixtureName)
    {
        $file = [__DIR__, 'fixtures', $fixtureName];
        return realpath(implode('/', $file));
    }

    public function testStylishDiff1()
    {
        $expected = file_get_contents($this->getFixtureFullPath('expectedResult1'));
        $this->assertSame($expected, $this->stylishDiff1);
    }

    public function testStylishDiff2()
    {
        $expected = file_get_contents($this->getFixtureFullPath('expectedResult2'));
        $this->assertSame($expected, $this->stylishDiff2);
    }

    public function testStylishDiff3()
    {
        $expected = file_get_contents($this->getFixtureFullPath('expectedResult3'));
        $this->assertSame($expected, $this->stylishDiff3);
    }

    public function testPlainDiff4()
    {
        $expected = file_get_contents($this->getFixtureFullPath('expectedResult4'));
        $this->assertSame($expected, $this->plainDiff4);
    }

    public function testJsonDiff5()
    {
        $expected = file_get_contents($this->getFixtureFullPath('expectedResult5'));
        $this->assertSame($expected, $this->jsonDiff5);
    }

    public function testParsers1()
    {
        $extension = 'txt';
        $toPathFile = 'filesForCompare/file1.txt';
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Unknown extension: '$extension'");
        parseData($extension, $toPathFile);
    }
    
    public function testParsers2()
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'emptyFile.json');
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Unknown data: '$tempFile'");
        parseJson($tempFile);
        unlink($tempFile);
    }

    public function testParsers3()
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'emptyFile.yml');
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Unknown data: '$tempFile'");
        parseYaml($tempFile);
        unlink($tempFile);
    }
}