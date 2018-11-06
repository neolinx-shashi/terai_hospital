<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Auth;
use View;
class ComposerServiceProvider extends ServiceProvider
{
  /**
  * Bootstrap the application services.
  *
  * @return void
  */
  public function boot()
  {

    View::composer('*', function ($view) {
    $user = Auth::user();
    //return $user;
    $view->with('user', $user);
    });

    View::composer('*', function ($view) {
      $side_menus = array();
      if(Auth::user()['user_type']=='superAdmin'){
        $side_menus=array(
          ['name'=>'Dashboard','link'=>'admin/dashboard','icon'=>'fa-dashboard'],
          ['name'=>'Permission','link'=>'admin/permission','icon'=>'fa-circle-o'],
          ['name'=>'App','link'=>'app','icon'=>'fa-circle-o'],
          ['name'=>'Client','link'=>'client','icon'=>'fa-circle-o'],
          ['name'=>'Form','link'=>'form','icon'=>'fa-circle-o'],
          ['name'=>'Event','link'=>'event/view','icon'=>'fa-circle-o'],
          ['name'=>'Contact','link'=>'contact/view','icon'=>'fa-circle-o'],
          ['name'=>'Sms','link'=>'sms','icon'=>'fa-circle-o'],
          ['name'=>'Email','link'=>'email','icon'=>'fa-circle-o'],
        );
      }
      if(Auth::user()['user_type']=='client'){
        $side_menus=array(
          ['name'=>'Dashboard','link'=>'admin/dashboard','icon'=>'fa-dashboard'],
          ['name'=>'Client','link'=>'client','icon'=>'fa-circle-o'],
          ['name'=>'Form','link'=>'form','icon'=>'fa-circle-o'],
          ['name'=>'Event','link'=>'event/view','icon'=>'fa-circle-o'],
          ['name'=>'Contact','link'=>'contact/view','icon'=>'fa-circle-o'],
          ['name'=>'Sms','link'=>'sms','icon'=>'fa-circle-o'],
          ['name'=>'Email','link'=>'email','icon'=>'fa-circle-o'],
        );
      }
      $view->with('side_menus', $side_menus);
    });
  }
  /**
  * Register the application services.
  *
  * @return void
  */
  public function register()
  {
    //
  }
}

<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{asset('adminlte/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{$user['name']}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <!-- <?php
                //echo '<pre>';
                    //print_r($side_menus);
                //echo '</pre>';
             ?> -->
            @foreach($side_menus as $menu)
            <li class="active treeview">
                <a href="{{url($menu['link'])}}">
                    <i class="fa {{$menu['icon']}}"></i> <span>{{$menu['name']}}</span>
                </a>
            </li>
            @endforeach
            
            @include('backend.layouts.generated_menu')
            <!-- <li class="treeview">
                <a href="#">
                    <i class="fa fa-laptop"></i>
                    <span>multi Lavel</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> One</a></li>
            
                    <li><a href="#"><i class="fa fa-circle-o"></i> Two</a></li>
                   
            
                   
                    <li><a href="#"><i class="fa fa-circle-o"></i> Three</a></li>
            
                    <li><a href="#"><i class="fa fa-circle-o"></i> Four</a></li>
                    
                </ul>
            </li> -->
            
            
            
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>