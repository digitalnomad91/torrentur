@extends('layouts.app')

@if(!$category)
@section('title', 'Top Torrents | 123Torrents - Torrent Search Engine')
@else
@section('title', 'Top '.$category->title.' Torrents | 123Torrents - Torrent Search Engine')

@endif

@section('description', 'Verified Torrents Download like Movies, Games, Music, Anime, TV Shows and Software, Bittorrent Downloading Absolutely for free at 123Torrents')


@section('content')
<style>
#breadcrumb_stats li {
    list-style-type: none;
    display: inline;
    margin-right: 70px;
}
.torrents_table td { font-size: 14px; }
</style>


<div style="height: 30px; background-color: #fcfcfc; border-bottom: 1px solid #d1cfc5;  border-top: 1px solid #f0f0f5;  box-shadow: 0 1px 3px rgba(0,0,0,0.10), 0 1px 2px rgba(0,0,0,0.12);">
    <div class="container" style="text-align: left; border: 1px solid #fcfcfc;">
    	<span><small style="font-size: 73%;">
        	<i class="fa fa-home"></i>  <a href="/" style="color: #777;">Home</a>
    	</small></span>

	    	<span><small  class="text-muted" style="font-size: 73%;">
	        	<i class="fa fa-angle-right"></i> Recent Torrents
	    	</small></span>
    </div>
</div>


<!--tab start-->
<div class="container blank">
    <div class="no-table-blank-state row" style="margin-top: 15px;">


        <section class="row component-section">
            <div class="col-md-12"> 
                <div class="pmd-card pmd-z-depth pmd-card-custom-view">
                    <div class="pmd-card-body">
                        <div class="row" id="nav_links"> 
                            <div class="col-md-2 col-sm-2 col-xs-6 align-center" style="text-align: center !important;">
                                <a href="/top/movies"><i class='fa fa-film' style="font-size: 28px;"></i><br>
                                <small class="text-muted">Movies</small></a>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-6 align-center" style="text-align: center !important;">
                                <a href="/top/tv"><i class='fa fa-tv' style="font-size: 28px;"></i><br>
                                <small class="text-muted">TV Shows</small></a>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-6 align-center" style="text-align: center !important;">
                                <a href="/top/games"><i class='fa fa-gamepad' style="font-size: 28px;"></i><br>
                                <small class="text-muted">Games</small></a>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-6 align-center" style="text-align: center !important;">
                                <a href="/top/music"><i class='fa fa-music' style="font-size: 28px;"></i><br>
                                <small class="text-muted">Music</small></a>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-6 align-center" style="text-align: center !important;">
                                <a href="/top/software"><i class='fa fa-cogs' style="font-size: 28px;"></i><br>
                                <small class="text-muted">Software</small></a>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-6 align-center" style="text-align: center !important;">
                                <a href="/top/xxx"><i class='fa fa-venus-mars' style="font-size: 28px;"></i><br>
                                <small class="text-muted">XXX</small></a>
                            </div>                                                                                                                      

                        </div>
                    </div>
                </div>
            </div>
        </section>


        <div class="row">
            <div class="col-md-12">


                <div class="row">
                    <section class="row component-section">
                   
                        <!-- hoverable rows table title and description  -->
                        <div class="col-md-12">

                            <div class="pull-left">
                                <div id="hoverable-row-table">
                                    @if(!$category)
                                        <h2><i class="fa fa-line-chart "></i> Popular Torrents <small>(All-Time)</small></h2>
                                    @else
                                        <h2>@php echo $category->icon() @endphp Popular {{$category->title}} Torrents <small>(All-Time)</small></h2>
                                    @endif
                                </div>
                            </div>

            

                        </div> <!-- hoverable rows table title and description end -->
                        
                        <div class="col-md-12">
                            <div class="component-box">
                            
                                <!-- hoverable rows table example -->
                                <div class="pmd-card pmd-z-depth pmd-card-custom-view">
                                    <div class="table-responsive">
                                        <table class="table pmd-table table-hover table-striped torrents_table">
                                            <thead>
                                                <tr>
                                                    <th class="">Title</th>
                                                    <th>&nbsp;</th>
													<th class="">Added</th>
                                                    <th class="">Size</th>
                                                    <th class="">Seeders</th>
                                                    <th class="">Leechers</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($torrents as $torrent)
                                                    <tr>
                                                        <td class=""><a href="/torrent/{{$torrent->id}}/{{$torrent->slug()}}" style="font-size: 14px;">{{$torrent->title}}</a></td>
                                                        <td>
                                                            <a href="http://itorrents.org/torrent/{{$torrent->info_hash}}.torrent" target="_blank" data-toggle="tooltip" title="Download Torrent">
                                                                <i class="fa fa-floppy-o"></i>
                                                            </a> &middot;
                                                            <a href="{{$torrent->MagnetURI()}}" data-toggle="tooltip" title="Magnet URI">
                                                                <i class="fa fa-magnet fa-rotate-180"></i>
                                                            </a>
                                                        </td>
					 									<td class="">{{\Carbon\Carbon::parse($torrent->created_at)->format('M jS, Y')}} 
					 								<small>({{\Carbon\Carbon::createFromTimeStamp(strtotime($torrent->created_at))->diffForHumans()}})</small></td>

                                                        <td class="">{{formatSizeUnits($torrent->size)}}</td>
                                                        <td class="text-center" style="color: green;"><i class="fa fa-arrow-up"></i> {{$torrent->seeders}}</td>
                                                        <td class="text-center" style="color: red;"><i class="fa fa-arrow-down"></i> {{$torrent->leechers}}</td>                                
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div> <!-- hoverable rows table example end -->
                            
                            </div>
                        </div>
                    </section>
                </div>



            </div>


        </div>
    </div>
</div>
@endsection
