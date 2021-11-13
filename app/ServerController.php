<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use auth;
use Redirect;
use App\Movie;
use App\Cast;
use App\Tag;
use App\Genre;
use App\Upload;
use App\Image;
use App\Certification;
use DB;
use App\Http\Controllers\IMDBController;
use App\Http\Controllers\IRCController;
use Log;
use App\Server;
use Response;
use App\ImageRepository;
use Defuse\Crypto\Crypto;

class ServerController extends Controller
{
  
  public function heartbeatAPI(Request $request) {
    $ip = $request->ip();
    $server = Server::where("ip", "=", $ip)->first();
    if(!isset($server->id)) return response()->json(['error' => 'Server not found.'.$ip]);

    $key = \Defuse\Crypto\Key::loadFromAsciiSafeString($server->password);
    $plaintext = \Defuse\Crypto\Crypto::Decrypt($request->input("data"), $key);

    $server->heartbeat_data = $plaintext;
    $server->save();

    $data = json_decode($plaintext);

    $hostname = $server->hostname;
    $load = implode(", ", $data->cpu->load);
    $cpu_percent = $data->cpu->user;
    $disk_percent = $data->disk[0]->percent;
    $ram_percent = $data->memory->percent;

    $colors = IRCController::colors();
    IRCController::alert($colors["lightred"].'[HeartBeat]'.$colors["nc"].' Ping from '.$hostname.". Load: (".$load.") [CPU: ".$cpu_percent."%] [RAM: ".$ram_percent."%] [Disk: ".$disk_percent."]", "#pre");

  }

  public function driveIDKnown(Request $request) {
        $colors = IRCController::colors();
        $data = json_decode($request->data);

        $imdb = new IMDBController;
        $ip = $request->ip();

        /* If Season value is set then use TV/Season controller methods instead */
        if($data->theSeason != "") {
          IRCController::alert($colors["green"].'[Drive ID]'.$colors["nc"].' Upload Created - '.$ip.' -'.$data->theTitle. '(TV)', "#pre");
          $movie = Movie::where("title", $data->theTitle)->first();

          if(!$movie) {
            $movie = $imdb->insertTVSeason($data);
          } 

          /* If no movie inserted returned then search for existing one */
          if(!$movie) die("Invalid movie."); /* If still nothing found then we can't do anything with this data */

        } else { /* Otherwise we have a regular movie (imdb title lookup) */
          
          IRCController::alert($colors["green"].'[Drive ID]'.$colors["nc"].' Upload Created - '.$ip.' -'.$data->theTitle. '(Movie)', "#pre");
          $movie = $imdb->insertNew($data->theTitle);

          /* If no movie inserted returned then search for existing one */
          if(!$movie) $movie = Movie::where("title", $data->theTitle)->first();
          if(!$movie) die("[]"); /* If still nothing found then we can't do anything with this data */
        }

        $server = Server::find(2);

        $url = (parse_url($data->theUrl));
        $url = explode("driveid=", $url["query"]);
        $url = end($url);
        $url = explode("&", $url);
        $driveid = $url[0];

        //download player cover photo

        $upload = new Upload;
        $upload->ident_id = $driveid = $url[0];
        $upload->server_id = 2;
        $upload->imdb_id = $movie->id;
        $upload->episode_title = "";
        $upload->episode_num = $data->theEpisode ? intval($data->theEpisode) : 0;
        $upload->views = 0;
        $upload->upload_percent = 0;
        $upload->referral_url = $data->referral_url;

        //download player cover photo
        if($data->playerCover) {
          ImageRepository::downloadFromUrl(
              $data->playerCover,
              '/var/www/harsh/public/cdn/movie_player_covers/'.$movie->id.'.jpg'
          );
        }

        // URL to file (link)
        $contentLength = 0;
        $file = $data->theUrl;

        $upload->size_bytes = get_size($data->theUrl);

        $upload->quality = $data->theQuality;
        $upload->save();

        return Response::json(array(
            'movie' => $movie, 
            'server' => $server->hostname,
            'url' => $data->theUrl
        ));

  }


  /* Function for downloading mp4 from known URL using cloudbot server */
  public function getCloudBot(Request $request) {
        $colors = IRCController::colors();
        $data = json_decode($request->data);
        $imdb = new IMDBController;
        $ip = $request->ip();

        /* If Season value is set then use TV/Season controller methods instead */
        if($data->theSeason != "") {
          IRCController::alert($colors["green"].'[CloudAPI]'.$colors["nc"].' '.$ip.' getCloudBot API Request -'.$data->theTitle. '(TV)', "#pre");
          $movie = Movie::where("title", $data->theTitle)->first();

          if(!$movie) {
            $movie = $imdb->insertTVSeason($data);
          } 

          /* If no movie inserted returned then search for existing one */
          if(!$movie) die("Invalid movie."); /* If still nothing found then we can't do anything with this data */

        } else { /* Otherwise we have a regular movie (imdb title lookup) */
          
          IRCController::alert($colors["green"].'[CloudAPI]'.$colors["nc"].' getCloudBot API Request -'.$data->theTitle. '(TV)', "#pre");
          $movie = $imdb->insertNew($data->theTitle);

          /* If no movie inserted returned then search for existing one */
          if(!$movie) $movie = Movie::where("title", $data->theTitle)->first();
          if(!$movie) die("[]"); /* If still nothing found then we can't do anything with this data */
        }

        $server = Server::find(2);

        return Response::json(array(
            'movie' => $movie, 
            'server' => $server->hostname,
            'url' => $data->theUrl
        ));

  }

}


/**
 * Returns the size of a file without downloading it, or -1 if the file
 * size could not be determined.
 *
 * @param $url - The location of the remote file to download. Cannot
 * be null or empty.
 *
 * @return The size of the file referenced by $url, or -1 if the size
 * could not be determined.
 */
function get_size( $url ) {
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_NOBODY, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  $data = curl_exec($ch);
  curl_close($ch);
  $length = explode("Content-Length:", $data);
  $length = str_replace("\n", " ", end($length));
  $length = explode(" ", $length)[1];

  return $length;
}