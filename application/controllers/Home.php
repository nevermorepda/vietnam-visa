<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$this->util->block_ip();
		$this->output->cache(CACHE_TIME);

		$info = new stdClass();
		$info->catid = ID_EXTRA_SERVICES;
		$services = $this->m_content->items($info,1,4);
		
		$visa_news_info = new stdClass();
		$visa_news_info->catid = 2;

		$faqs_news_info = new stdClass();
		$faqs_news_info->catid = 4;

		$view_data = array();
		$view_data['services']  = $services;
		$view_data['nations'] = $this->m_country->items(NULL, 1);
		$view_data['visa_news'] = $this->m_content->items($visa_news_info, 1, 8);
		$view_data['faq_news'] = $this->m_content->items($faqs_news_info, 1, 8);

		$tmpl_content = array();
		$tmpl_content['tabindex']  = "home";
		$tmpl_content['content']   = $this->load->view("home", $view_data, TRUE);
		$this->load->view('layout/main', $tmpl_content);
	}
}

?>