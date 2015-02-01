<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	/**
	 * loc thanh phan rõ trong mang khong bat buoc
	 *
	 * @param $input
	 * @return array
	 */
	public function InputFilter($input){
		return array_filter($input);
	}
}
