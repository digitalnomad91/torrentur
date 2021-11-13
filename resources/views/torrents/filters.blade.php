<div class="pmd-card pmd-z-depth" style="margin-bottom: 15px;" id="torrents_search">
    <div class="pmd-card-body"> 
      <h3><i class="fa fa-search"></i> Search Torrents <small class="text-muted">Advanced filters to help you find the right torrent.</small></h3>
      <hr>

        <form role="form" action="/browse" method="get">

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group pmd-textfield pmd-textfield-floating-label">
                    <input class="form-control airport_search_autosuggest" placeholder="Keywords" type="text" name="keyword" value="{{$request->input('keyword')}}"><span class="pmd-textfield-focused"></span>
                </div>
            </div>

            <div class="col-sm-4">
              <div class="form-group pmd-textfield pmd-textfield-floating-label">       
                <select class="select-simple form-control pmd-select2" tabindex="-1" aria-hidden="true">
                  <option>Movies</option>
                  <option>TV Shows</option>
                  <option>Music</option>
                  <option>Games</option>
                  <option>Software</option>
                  <option>XXX</option>
                </select>
              </div>
            </div>

            <div class="col-sm-2">
                <button type="submit" class="btn btn-primary pmd-ripple-effect">Search Torrents</button>
            </div>
        </div>




        </form>
    </div>
</div>


<script type="text/javascript">
$(document).ready(function() {

    /* Airline Search Auto-Suggest */
     var options = {
          url: function(phrase) {
            return "/flights/airline/search?phrase="+phrase;
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
            data.phrase = $("#example-ajax-post").val();
            return data;
          },

          requestDelay: 400,

          cssClasses: "sheroes",

          template: {
            type: "iconLeft",
            fields: {
              iconSrc: "icon"
            }
          },

          list: {
            showAnimation: {
              type: "slide"
            },
            hideAnimation: {
              type: "slide"
            }
          }
    };
    $("#airline_search").easyAutocomplete(options);
    /* End Airline Search Autosuggest */


    /* Airport Search Auto-Suggest */
     var options = {
          url: function(phrase) {
            return "/flights/airport/search?phrase="+phrase;
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
            data.phrase = $("#example-ajax-post").val();
            return data;
          },

          requestDelay: 400,

          cssClasses: "sheroes",

          template: {
            type: "iconLeft",
            fields: {
              iconSrc: "icon"
            }
          },

          list: {
            showAnimation: {
              type: "slide"
            },
            hideAnimation: {
              type: "slide"
            }
          }
    };
    $(".airport_search_autosuggest").easyAutocomplete(options);
    /* End Airline Search Autosuggest */

})
</script>