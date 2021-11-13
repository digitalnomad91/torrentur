@extends('layouts.app')
@section('title', '123Torrents - Torrent Search Engine')
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
    </div>
</div>


<style>
#hm-search .form-control {
    height: 56px;
    background: #fff;
    font-size: 20px;
    padding-left: 20px;
    padding-right: 90px;
    box-shadow: none;
    color: #111;
    border: 1px solid rgba(0,0,0,0.2);
    border-radius: 5px;
    display: inline;
    width: 92.3%;
    padding-right: 0px;
    border-right: 0px;
}

</style>

<!--tab start-->
<div class="container blank">
    <div class="no-table-blank-state row" style="margin-top: 15px;">


                <div class="row">
                    <section class="row component-section" style="margin-top: 0px;">
                        <div class="col-md-12">
                            <div class="card-content-area">
                                <div class="content-area-header">
                                    <a href="#">123Torrents (beta)</a>
                                </div>
                                <div class="content-area-body">
                                  123Torrents helps people finding latest torrent files and magnet links used for p2p file sharing through BitTorrent protocol. 123Torrents origin is based on the great success of our 123Movies brand which has prove to be the leader in watchinv movies and tv shows online outside of the p2p torrent world. 
                                </div>
                            </div>
                        </div>
                    </section>
                </div>


        <section class="row component-section" style="margin-top: 0px;">         
            <div id="hm-search">
                <div class="search-content">
                    <input maxlength="100" autocomplete="off" name="keyword-home" class="form-control search-input" placeholder="Enter Movies or Series name" type="text" id="torrent_search">

                    <button class="btn" style="display: inline; background-color: #259b24; height: 56px; position: relative; top: -4px; left: -7px; border-radius: 4px; border-top-left-radius: 0px; border-bottom-left-radius: 0px;" id="torrent_search_btn"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </section>

        <div class="row text-center">
            <a href="/home" class="btn btn-lg btn-success" style="padding: 18px;">Classic View? Click Here</a>
        </div>


        <section class="row component-section">
            <div class="col-md-12"> 
                <div class="pmd-card pmd-z-depth pmd-card-custom-view">
                    <div class="pmd-card-body">
                        <div class="row" id="nav_links"> 
                            <div class="col-md-2 col-sm-2 col-xs-6 align-center" style="text-align: center !important;">
                                <a href="/browse/movies"><i class='fa fa-film' style="font-size: 28px;"></i><br>
                                <small class="text-muted">Movies</small></a>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-6 align-center" style="text-align: center !important;">
                                <a href="/browse/tv"><i class='fa fa-tv' style="font-size: 28px;"></i><br>
                                <small class="text-muted">TV Shows</small></a>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-6 align-center" style="text-align: center !important;">
                                <a href="/browse/games"><i class='fa fa-gamepad' style="font-size: 28px;"></i><br>
                                <small class="text-muted">Games</small></a>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-6 align-center" style="text-align: center !important;">
                                <a href="/browse/music"><i class='fa fa-music' style="font-size: 28px;"></i><br>
                                <small class="text-muted">Music</small></a>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-6 align-center" style="text-align: center !important;">
                                <a href="/browse/software"><i class='fa fa-cogs' style="font-size: 28px;"></i><br>
                                <small class="text-muted">Software</small></a>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-6 align-center" style="text-align: center !important;">
                                <a href="/browse/xxx"><i class='fa fa-venus-mars' style="font-size: 28px;"></i><br>
                                <small class="text-muted">XXX</small></a>
                            </div>                                                                                                                      

                        </div>
                    </div>
                </div>
            </div>
        </section>


    </div>
</div>

<style>
.sheroes { display: inline; }
</style>


<script type="text/javascript">
$(document).ready(function() {


    $("#torrent_search_btn").click(function() {
        $("#torrent_search_btn").addClass("disabled").attr("disabled", true).html("<i class='fa fa-spin fa-spinner' style='color: white; font-size: 14px;'></i>");
        window.location = '/browse?keyword='+$("#torrent_search").val();
        return false;
    });


    /* Airport Search Auto-Suggest */
     var options = {
          url: function(phrase) {
            return "/api/torrents/search?keyword="+phrase;
          },

          getValue: function(element) {
            return element.name;

          },

          ajaxSettings: {
            dataType: "json",
            method: "GET",
            data: {
              dataType: "json"
            }
          },

          preparePostData: function(data) {
            $("#torrent_search_btn").attr("disabled", "true").addClass("disabled").html('<i class="fa fa-spinner fa-spin"></i>');
            data.phrase = $("#example-ajax-post").val();
            return data;
          },

          requestDelay: 400,

          cssClasses: "sheroes",

        template: {
            type: "custom",
            method: function(value, item) {
                return item.icon + " | " + value;
            }
        },

          list: {
            showAnimation: {
              type: "slide"
            },
            hideAnimation: {
              type: "slide"
            },
            onSelectItemEvent: function() {
                var index = $("#function-index").getSelectedItemIndex();
                $("#index-holder").val(index).trigger("change");

                $("#torrent_search_btn").addClass("disabled").attr("disabled", true).html("<i class='fa fa-spin fa-spinner' style='color: white; font-size: 14px;'></i>");
                window.location = '/browse?keyword='+$("#torrent_search").val();
                
            },
            onLoadEvent: function() {
                $("#torrent_search_btn").removeAttr("disabled").removeClass("disabled").html('<i class="fa fa-search"></i>');
            }

          }
    };
    $("#torrent_search").easyAutocomplete(options);
    /* End Airline Search Autosuggest */

})


</script>

@endsection
