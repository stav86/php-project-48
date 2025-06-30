<?php

namespace GenDiff\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use function GenDiff\Src\Differ\genDiff;

class GenDiffTest extends TestCase
{
    private $genDiff1;
    private $genDiff2;
    private $genDiff3;

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

        $this->genDiff1 = genDiff($data1, $data2);
        $this->genDiff2 = genDiff($data3, $data4);
        $this->genDiff3 = genDiff($data5, $data6);
    }

    private function getFixtureFullPath($fixtureName)
    {
        $file = [__DIR__, 'fixtures', $fixtureName];
        return realpath(implode('/', $file));
    }

    public function testGenDiff1()
    {
        $expected = file_get_contents($this->getFixtureFullPath('expectedResult1'), true);
        $this->assertEquals($expected , $this->genDiff1);
    }

    public function testGenDiff2()
    {
        $expected = file_get_contents($this->getFixtureFullPath('expectedResult2'), true);
        $this->assertEquals($expected, $this->genDiff2);
    }

    public function testGenDiff3()
    {
        $expected = file_get_contents($this->getFixtureFullPath('expectedResult3'), true);
        $this->assertEquals($expected, $this->genDiff3);
    }
}
