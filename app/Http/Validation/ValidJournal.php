<?php

use App\Http\Validation;

class ValidJournal implements Rules
{

	public function passes($attribute, $value)
	{

	}


	public function message()
	{
		return 'Failed';
	}
}