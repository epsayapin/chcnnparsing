<?php

namespace Tests\Unit;

use App\Library\BookStoreParsing\ChaconneParsing;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use PHPUnit\Framework\TestCase;

class ChaconneParsingTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function testGetSearchResultMustReturnSearchResult(){

        $searchQuery = $this->getSearchQuery();
        $searchResult = ChaconneParsing::getSearchResultPage($searchQuery);
    
        echo "\nUsed query - " . $searchQuery . "\n";
        echo "Количество кинг - " . count($searchResult->bookList) . "\n";
        

        $this->assertTrue(isset($searchResult->bookList));
        $this->assertGreaterThan(0, count($searchResult->bookList));
        $this->assertLessThanOrEqual(ChaconneParsing::MAX_BOOKS_ON_PAGE, count($searchResult->bookList));
        $this->assertTrue(isset($searchResult->currentPage));
//        $this->assertTrue(isset($searchResult->totalPages));
//        $this->assertGreaterThan(0, $searchResult->totalPages);

        foreach($searchResult->bookList as $book)
        {
            $this->assertTrue(isset($book["title"]));
            $this->assertTrue(isset($book["code"]));
        }
		
    }


    private function getSearchQuery(){

        $searchQuerys = [
                        'Ведьмак', 
                        'Сорокин', 
                        'Гарри Поттер',
                        'Пушкин', 
                        'Достоевский', 
                        'Иванов', 
                        'Пелевин', 
                        'Воннегут',
                        'Стивен Кинг',
                        'Искусство',
                        'Психология отношений',
                        'Зигмунд Фрейд',
                        'Капитанская дочка'
                    ];
        $count = count($searchQuerys);

        return $searchQuerys[rand(0, $count - 1)];
    }

    private function getCode()
    {
        $bookCodes = [
            //'2617830',
            '4052565',
            '4052340',
            '4052821',
            '4000529',
            '3978197',
            '4000527',
            '2113226',
            '3791720',
            //'3869778'
        ];

        $count = count($bookCodes);
        return $bookCodes[rand(0, $count - 1)];
    }


}