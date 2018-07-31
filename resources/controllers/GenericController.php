<?php

	class GenericController {

		static public function messaggio(){
			return success('Hello world!');
		}

		static public function errore(){
			return error('Errore!');
		}
	}
?>