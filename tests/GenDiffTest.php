<?php

namespace GenDiff\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use InvalidArgumentException;

use function Differ\Differ\genDiff;
use function Differ\Formatters\{
    Stylish\getStylish,
    Plain\getPlain,
    Json\getJson,
};
use function Differ\Parsers\{
    parseData,
    parseJson,
    parseYaml,
};

class GenDiffTest extends TestCase
{
    private function getFixtureFullPath($fixtureName)
    {
        $file = [__DIR__, 'fixtures', $fixtureName];
        return realpath(implode('/', $file));
    }

    public function testStylishDiff1()
    {
        $file1 = $this->getFixtureFullPath('file1.json');
        $file2 = $this->getFixtureFullPath('file2.json');
        $expected = file_get_contents($this->getFixtureFullPath('expectedResult1'));
        $result = genDiff($file1, $file2);
        $this->assertSame($expected, $result);
    }

    public function testStylishDiff2()
    {
        $file3 = $this->getFixtureFullPath('file3.yaml');
        $file4 = $this->getFixtureFullPath('file4.yaml');
        $expected = file_get_contents($this->getFixtureFullPath('expectedResult2'));
        $result = genDiff($file3, $file4);
        $this->assertSame($expected, $result);
    }

    public function testStylishDiff3()
    {
        $file5 = $this->getFixtureFullPath('file5.yaml');
        $file6 = $this->getFixtureFullPath('file6.yaml');
        $expected = file_get_contents($this->getFixtureFullPath('expectedResult3'));
        $result = genDiff($file5, $file6);
        $this->assertSame($expected, $result);
    }

    public function testPlainDiff4()
    {
        $file5 = $this->getFixtureFullPath('file5.yaml');
        $file6 = $this->getFixtureFullPath('file6.yaml');
        $expected = file_get_contents($this->getFixtureFullPath('expectedResult4'));
        $result = genDiff($file5, $file6, 'plain');
        $this->assertSame($expected, $result);
    }

    public function testJsonDiff5()
    {
        $file5 = $this->getFixtureFullPath('file5.yaml');
        $file6 = $this->getFixtureFullPath('file6.yaml');
        $expected = file_get_contents($this->getFixtureFullPath('expectedResult5'));
        $result = genDiff($file5, $file6, 'json');
        $this->assertSame($expected, $result);
    }

    public function testStylishDiff6()
    {
        $file5 = $this->getFixtureFullPath('file5.yaml');
        $file7 = $this->getFixtureFullPath('file7.yml');
        $expected = file_get_contents($this->getFixtureFullPath('expectedResult3'));
        $result = genDiff($file5, $file7);
        $this->assertSame($expected, $result);
    }

    public function testParseJson7()
    {
        $pathFile = $this->getFixtureFullPath('file1.yaml');
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("File not found '$pathFile'");
        parseJson($pathFile);
    }

    public function testParseYaml8()
    {
        $pathFile = $this->getFixtureFullPath('file1.yaml');
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("File not found '$pathFile'");
        parseYaml($pathFile);
    }
}
