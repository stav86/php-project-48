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

/**
 * @codeCoverageIgnore
 */

class GenDiffTest extends TestCase
{
    private $stylishDiff1;
    private $stylishDiff2;
    private $stylishDiff3;
    private $plainDiff4;
    private $jsonDiff5;
    private $stylishDiff6;

    protected function setUp(): void
    {
        $file1 = $this->getFixtureFullPath('file1.json');
        $file2 = $this->getFixtureFullPath('file2.json');
        $file3 = $this->getFixtureFullPath('file3.yaml');
        $file4 = $this->getFixtureFullPath('file4.yaml');
        $file5 = $this->getFixtureFullPath('file5.yaml');
        $file6 = $this->getFixtureFullPath('file6.yaml');
        $file7 = $this->getFixtureFullPath('file7.yml');

        $this->stylishDiff1 = genDiff($file1, $file2);
        $this->stylishDiff2 = genDiff($file3, $file4);
        $this->stylishDiff3 = genDiff($file5, $file6, 'stylish');
        $this->plainDiff4 = genDiff($file5, $file6, 'plain');
        $this->jsonDiff5 = genDiff($file5, $file6, 'json');
        $this->stylishDiff6 = genDiff($file5, $file7);
    }

    private function getFixtureFullPath($fixtureName)
    {
        $file = [__DIR__, 'fixtures', $fixtureName];
        $pathFile = realpath(implode('/', $file));
        if ($pathFile === false || !file_exists($pathFile)) {
            throw new InvalidArgumentException("Fixture file not found: '$pathFile'");
        }

        return $pathFile;
    }

    public function testStylishDiff1()
    {
        $expected = file_get_contents($this->getFixtureFullPath('expectedResult1'));
        $result = $this->stylishDiff1;
        $this->assertSame($expected, $result);
    }

    public function testStylishDiff2()
    {
        $expected = file_get_contents($this->getFixtureFullPath('expectedResult2'));
        $result = $this->stylishDiff2;
        $this->assertSame($expected, $result);
    }

    public function testStylishDiff3()
    {
        $expected = file_get_contents($this->getFixtureFullPath('expectedResult3'));
        $result = $this->stylishDiff3;
        $this->assertSame($expected, $result);
    }

    public function testPlainDiff4()
    {
        $expected = file_get_contents($this->getFixtureFullPath('expectedResult4'));
        $result = $this->plainDiff4;
        $this->assertSame($expected, $result);
    }

    public function testJsonDiff5()
    {
        $expected = file_get_contents($this->getFixtureFullPath('expectedResult5'));
        $result = $this->jsonDiff5;
        $this->assertSame($expected, $result);
    }

    public function testStylishDiff6()
    {
        $expected = file_get_contents($this->getFixtureFullPath('expectedResult3'));
        $result = $this->stylishDiff6;
        $this->assertSame($expected, $result);
    }
}
