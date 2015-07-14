<?php

require_once('src/DataMunger.php');

class _MockObj {
    public $foo = 'bar';
}

class _MockObj2 {
    public function __construct($id) {
        $this->id = $id;
    }
}

class DataMungerTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        $this->munger = new DataMunger();
    }

    public function testPrefixList() {
        $starting = ['cat', 'dog'];
        $res = $this->munger->prefixList($starting, 'cool ')->getData();
        return $this->assertEquals($res, ['cool cat', 'cool dog']);
    }

    public function testSuffixList() {
        $starting = ['cat', 'dog'];
        $res = $this->munger->suffixList($starting, ' is cool')->getData();
        return $this->assertEquals($res, ['cat is cool', 'dog is cool']);
    }

    public function testPrefixSuffixList() {
        $starting = ['cat', 'dog'];
        $res = $this->munger->prefixSuffixList($starting, 'cool ', ' is cool')->getData();
        return $this->assertEquals($res, ['cool cat is cool', 'cool dog is cool']);
    }

    public function testGetFirstOfObject() {
        $data = [
            ['first' => 0],
            ['second' => 1],
            ['third' => 2],
        ];
        $res = $this->munger->getFirstOfObject($data)->getData();
        return $this->assertEquals($res, ['first' => 0]);
    }

    public function testArrayValFilter() {
        $data = [
            'foo' => 'bar',
            'bar' => 'foo',
            'bim' => 'bam',
            'bam' => 'bim'
        ];
        $res = $this->munger->arrayValFilter(['bar', 'foo'], $data)->getData();
        return $this->assertEquals($res, ['foo' => 'bar', 'bar' => 'foo']);
    }

    public function testArrayValPrune() {
        $data = [
            'foo' => 'bar',
            'bar' => 'foo',
            'bim' => 'bam',
            'bam' => 'bim'
        ];
        $res = $this->munger->arrayValPrune(['bar', 'foo', 'bim'], $data)->getData();
        return $this->assertEquals($res, ['bim' => 'bam']);
    }

    public function testArrayKeyFilter() {
        $data = [
            'foo' => 'bar',
            'bar' => 'foo',
            'bim' => 'bam',
            'bam' => 'bim'
        ];
        $res = $this->munger->arrayKeyFilter(['foo', 'bim'], $data)->getData();
        return $this->assertEquals($res, ['foo' => 'bar', 'bim' => 'bam']);
    }

    public function testArrayKeyPrune() {
        $data = [
            'foo' => 'bar',
            'bar' => 'foo',
            'bim' => 'bam',
            'bam' => 'bim'
        ];
        $res = $this->munger->arrayKeyPrune(['foo', 'bar', 'bim'], $data)->getData();
        return $this->assertEquals($res, ['bam' => 'bim']);
    }

    public function testExtractObjValsByKey() {
        $data = [
            new _MockObj2('id_01'),
            new _MockObj2('id_02'),
        ];
        $expected = ['id_01', 'id_02'];
        $res = $this->munger->extractObjValsByKey('id', $data)->getData();
        return $this->assertEquals($res, $expected);
    }

    public function testGetKeys() {
        $mockarr = ['foo' => 'bar'];
        $res_obj = $this->munger->getKeys(new _MockObj())->getData();
        return $this->assertEquals($res_obj, $mockarr);
    }

    public function testKeyByVal() {
        $data = [
            ['id' => 'id_01'],
            ['id' => 'id_02'],
        ];
        $expected = [
            'id_01' => ['id' => 'id_01'],
            'id_02' => ['id' => 'id_02'],
        ];
        $res = $this->munger->keyByVal('id', $data)->getData();
        return $this->assertEquals($res, $expected);
    }

    public function testTransformVals() {
        $data = [
            'foo' => 'bar',
            'bam' => 'bim'
        ];
        $expected = [
            'foo' => 'BAR',
            'bam' => 'BIM_'
        ];
        $res = $this->munger->transformVals(['bar' => 'BAR', 'bim' => 'BIM_'], $data)->getData();
        return $this->assertEquals($res, $expected);
    }

    public function testTransformKeys() {
        $data = [
            'foo' => 'bar',
            'bam' => 'bim'
        ];
        $expected = [
            'FOO' => 'bar',
            '_BAM' => 'bim'
        ];
        $res = $this->munger->transformKeys(['foo' => 'FOO', 'bam' => '_BAM'], $data)->getData();
        return $this->assertEquals($res, $expected);
    }
}
