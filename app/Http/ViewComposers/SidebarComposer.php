<?php

namespace TradefiUBA\Http\ViewComposers;

use TradefiUBA\Bank;
use TradefiUBA\News;
use TradefiUBA\TransactionType;
use TradefiUBA\TransferType;
use Illuminate\View\View;
use TradefiUBA\Menu;
// use TradefiUBA\Role;

class SidebarComposer
{
    // public $user
    /**
     * Create a movie composer.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $transfer_types    = TransferType::take('TransferTypeRef', 'TransferType');
        $trabsaction_types = TransactionType::take('TransactionTypeRef', 'TransactionType');
        // $banks             = Bank::all();
        $banks      = Bank::take('name', 'id');
        $gl_balance = number_format(\DB::table('tblGL')->select('ClearedBalance')
                ->where('CustomerID', auth()->user()->id)
                ->where('AccountTypeID', 1)
                ->first()->ClearedBalance, 2);
        $book_balance = number_format(\DB::table('tblGL')->select('BookBalance')
                ->where('CustomerID', auth()->user()->id)
                ->where('AccountTypeID', 1)
                ->first()->BookBalance, 2);
        $tradefi_news = News::all();
        $view->with('transfer_types', $transfer_types);
        $view->with('gl_balance', $gl_balance);
        $view->with('book_balance', $book_balance);
        $view->with('banks', $banks);
        $view->with('tradefi_news', $tradefi_news);

        $roles = auth()->user()->roles;

        if (auth()->user()->company_id == '1') {
          $parent_menus = Menu::where('parent_id', '0')->orderBy('order')->get();
        } else {
          // is parent, AND (has roles OR has children (where has roles))
          $parent_menus = Menu::where('parent_id', '0')->where(function($q1) use($roles) {
            $q1->whereHas('roles', function($q2) use($roles) {
              $q2->whereIn('id', $roles->pluck('id')->toArray());
            })->orWhereHas('children', function($q3) use($roles) {
              $q3->whereHas('roles', function($q4) use($roles) {
                $q4->whereIn('id', $roles->pluck('id')->toArray());
              });
            });
          })->orderBy('order')->get();
        }
        
        // dd(Menu::find(1)->children);

        $view->with(compact('parent_menus'));
    }
}
