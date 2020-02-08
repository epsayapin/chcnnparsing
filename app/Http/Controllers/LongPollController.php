<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram;
use App\Library;
use App\Library\StartCommand;
use App\Library\ChcnnParsing;
use App\Library\TelegramBotMessages;

use \App\Entity;


class LongPollController extends Controller
{
    //

	public function longpoll()
	{


/*
		$searchResult = ChcnnParsing::getBookList($lastMessage["message"]["text"]);

		$str = "";

		foreach($searchResult[0]["bookList"] as $title)
		{
			$str .= $title . "\n";
		}

		$response = Telegram::sendMessage([
		'chat_id' => '117157138', 
		'text' => $str 
		]);

		$messageId = $response->getMessageId();
*/
		$entity = Entity::findOrFail(2);
		$status = $entity->status;
		$attemps = 1;
		$attempsLimit = 1;

		while ($status === "PENDING" && $attemps <= $attempsLimit)
		{
			sleep(2);

			$updates = Telegram::getUpdates();

			//return $updates;
			$chatId = $updates[0]['message']['chat']['id'];
			//$lastMessage = $updates[count($updates) - 1];
//			$update = Telegram::commandsHandler(false, ['timeout' => 30]);			

			TelegramBotMessages::showSearchResult($chatId);

			$status = $entity->refresh()->status;
			$attemps++;
		}

		return "Time is Out";
	}
}
