<?php
/*
Plugin Name: Company-EC linking
Plugin URI: http://www.liberta.net/
Description: リベルタのブランドサイトの商品ページとカンパニーECのサイトカートを連動させるためプラグインです。
Version: 0.1
Author: Kohei okuno
*/

	//**************************************************************************************
    // plugin deactivation
    //**************************************************************************************
    public function deactivation(){
    	$option_file = dirname(__FILE__) . '/' . self::OPTION_SAVE_FILE;
    	$wk_options = serialize( $this->options );
    	if ( file_put_contents( $option_file, $wk_options ) && file_exists( $option_file ) )
    		delete_option( self::OPTION_NAME );
    }
    
    //**************************************************************************************
    // plugin uninstall
    //**************************************************************************************
    public function uninstall(){
    	$option_file = dirname(__FILE__) . '/' . self::OPTION_SAVE_FILE;
    	if ( file_exists($option_file) )
    		unlink( $option_file );
    	delete_option( self::OPTION_NAME );
    }
require_once('config.php');

