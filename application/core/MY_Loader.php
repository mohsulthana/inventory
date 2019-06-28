<?php

class MY_Loader extends CI_Loader {
  public function template($template_name, $vars = array(), $return = FALSE)
  {
    if($return):
      $content  = $this->view('backend/layouts/header', $vars, $return);
      $content .= $this->view('backend/layouts/sidebar', $vars, $return);
      $content .= $this->view('backend/layouts/navbar', $vars, $return);
      $content .= $this->view($template_name, $vars, $return);
      $content .= $this->view('backend/layouts/footer', $vars, $return);

      return $content;
    else:
      $this->view('backend/layouts/header', $vars);
      $this->view('backend/layouts/sidebar', $vars);
      $this->view('backend/layouts/navbar', $vars);
      $this->view($template_name, $vars);
      $this->view('backend/layouts/footer', $vars);
    endif;
  }
}