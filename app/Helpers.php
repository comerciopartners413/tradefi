<?php

use TradefiUBA\TradeData;

// Return trades for a specific date, if no date, return trades for today
if (!function_exists('trades_today')) {
  function trades_today($date = null)
  {
      if (empty($date))
      $date = date('Y-m-d');
      
      return TradeData::whereDate('TradeDate', $date)->get();
  }
}

// Count trades for a specific date, if no date, count trades for today
// Selecting only one column for speed purposes.
if (!function_exists('count_trades')) {
  function count_trades($date = null)
  {
      if (empty($date))
      $date = date('Y-m-d');
      
      return TradeData::select('TradeDataRef')->whereDate('TradeDate', $date)->where('ApprovedFlag', true)->count();
  }
}

// $type: 1 or 2 (Buy or Sell)
if (!function_exists('count_tbs')) {
  function count_tbs(int $type, $date = null)
  {
      if (empty($date))
      $date = date('Y-m-d');
      
      return TradeData::select('TradeDataRef')
      ->join('tblSecurity', 'SecurityRef', '=', 'SecurityID')
      ->where('tblSecurity.ProductID', '2')
      ->where('TransactionTypeID', $type)
      ->whereDate('TradeDate', $date)
      ->where('tblTradeData.ApprovedFlag', true)
      ->count();
  }
}

// $type: 1 or 2 (Buy or Sell)
if (!function_exists('count_bonds')) {
  function count_bonds(int $type, $date = null)
  {
      if (empty($date))
      $date = date('Y-m-d');
      
      return TradeData::select('TradeDataRef')
      ->join('tblSecurity', 'SecurityRef', '=', 'SecurityID')
      ->where('tblSecurity.ProductID', '1')
      ->where('TransactionTypeID', $type)
      ->whereDate('TradeDate', $date)
      ->where('tblTradeData.ApprovedFlag', true)
      ->count();
  }
}

// Password Generator
if (!function_exists('password_generator')) {
  function password_generator($len = 8) {
      $letters = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
      $chars = "!@@##$%?&*=+";
      $pass = null;
      // $length = strlen($letters);
      for ($x = 0; $x < ($len-1); $x++) {
          $n = rand(0, strlen($letters)-1);
          $pass .= $letters[$n];
      }
      $pass .= $chars[rand(0, strlen($chars)-1)];
      $pass = str_shuffle($pass);
      return $pass;
  }
  // echo pwGenerator();
}

// Random Digits
if (!function_exists('random_digits')) {
  function random_digits($len = 10) {
    $gen = str_pad(rand(0, pow(10, $len)-1), $len, '0', STR_PAD_LEFT);
    return $gen;
  }
}