<?php

//One copy of any of the five books costs 8 EUR. If, however, you buy two different books from the series, 
// you get a 5% discount on those two books. If you buy 3 different books, you get a 10% discount. 
// With 4 different books, you get a 20% discount. If you go the whole hog, and buy all 5, 
// you get a huge 25% discount.
//
//Note that if you buy, say, four books, of which 3 are different titles, you get a 10% discount 
// on the 3 that form part of a set, but the fourth book still costs 8 EUR.
//
//Potter mania is sweeping the country and parents of teenagers everywhere are queueing up with shopping 
// baskets overflowing with Potter books. Your mission is to write a piece of code to calculate the price 
// of any conceivable shopping basket, giving as big a discount as possible.
//
//For example, how much does this basket of books cost?
//
//    2 copies of the first book
//  2 copies of the second book
//  2 copies of the third book
//  1 copy of the fourth book
//  1 copy of the fifth book
//

class PotterManiaTest extends PHPUnit_Framework_TestCase
{
    public function testSimpleNonDiscount()
    {
        $this->assertEquals(8 * 2, PotterMania::price([1,1]));
        $this->assertEquals(8 * 3, PotterMania::price([1,1,1]));
        $this->assertEquals(8 * 6, PotterMania::price([1,1,1,1,1,1]));
    }
    
    public function testSimpleDiscount()
    {
        // calculate cost of set of some identical books
        // метод принимает данные о книгах в следующем формате:
        // [book_id, book_id, book_id_2]
        
        $this->assertEquals(8 * 1, PotterMania::price([1]));
        $this->assertEquals(8 * 2 * 0.95, PotterMania::price([1,2]));
        $this->assertEquals(8 * 3 * 0.9, PotterMania::price([1,2,3]));
        $this->assertEquals(8 * 4 * 0.8, PotterMania::price([1,2,3,4]));
        $this->assertEquals(8 * 5 * 0.75, PotterMania::price([1,2,3,4,5]));
    }
    
    public function testSeveralDiscount()
    {
        // calculate cost of set of different books
        // для набора разных книг
        $this->assertEquals(8 + (8 * 2 * 0.95), PotterMania::price([0, 0, 1]));
        $this->assertEquals(2 * (8 * 2 * 0.95), PotterMania::price([0, 0, 1, 1]));
        $this->assertEquals((8 * 4 * 0.8) + (8 * 2 * 0.95), PotterMania::price([0, 0, 1, 2, 2, 3]));
        $this->assertEquals(8 + (8 * 5 * 0.75), PotterMania::price([0, 1, 1, 2, 3, 4]));
    }
    
    
    public function testEdgeCases()
    {
        $this->assertEquals(2 * (8 * 4 * 0.8), PotterMania::price([0, 0, 1, 1, 2, 2, 3, 4]));
        $this->assertEquals(3 * (8 * 5 * 0.75) + 2 * (8 * 4 * 0.8), PotterMania::price([0, 0, 0, 0, 0, 
                                                                                       1, 1, 1, 1, 1, 
                                                                                       2, 2, 2, 2, 
                                                                                       3, 3, 3, 3, 3, 
                                                                                       4, 4, 4, 4]));
    }
    
} 