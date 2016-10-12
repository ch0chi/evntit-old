<?php
ob_start();
require_once 'core/init.php';

require_once 'vendor/autoload.php';
$relPath = realPath($_SERVER['DOCUMENT_ROOT']);

//create new instances
$events = new Events();
$count=$events->countAll();
$registrant = new Registrants();
$count=0;
/**
 * create instance of Search class and parse users location
 */
$location = Input::get('locationSearch');
$search = new Search();
if(Input::exists()){

        if($search->checkIfValidlocation($location)){
            $search->parseSearchLocation($location);
            $inputtedCity = $search->fetchCity();
            $city = $events->cleanString($inputtedCity);
            $state = $search->fetchState();
            $category = Input::get('category');
            if($search->checkValidState()){

                Redirect::to("search/$category/$state/$city");
            }else{
                $count=1;
                if($count===1){
                    include('header.php');
                    echo "<div class=\"col-xs-6\"><p>Please enter a valid state.</p></div>";
                }

            }

        }else{

        }
}



$count=2;
if($count===2){
    include('header.php');
}
?>

<div id="welcome" class="container-fluid">
    <div class="container">
        <div class="row">
            <h1 style="color:white;font-size:30px;"><noscript>This site works best with javascript. Please enable it to get the best experience.</noscript></h1>
            <img src="images/logoMed.png" class="img-responsive center-block">
            <div id="searchBar" class="container">
                <div class="row">
                <div id="filter-panel" class=" filter-panel">
                    <div id="search" class="panel panel-default">
                        <div class="panel-body">
                            <form class="form-inline" method="post" role="form" enctype="multipart/form-data" autocomplete="off">
                                <div class="form-group">
                                    <label class="filter-col"  for="category">I'm looking for:</label>
                                    <select  id="category" name="category" class="form-control input-lg" required>
                                        <option value="" disabled selected>Select a Category</option>
                                        <option value="Outdoors">Outdoors</option>
                                        <option value="Sports">Sports</option>
                                        <option value="Gaming">Gaming</option>
                                        <option value="Music">Music</option>
                                        <option value="Movies">Movies</option>
                                        <option value="Food">Food</option>
                                        <option value="Programming">Programming</option>
                                        <option value="Politics">Politics</option>
                                        <option value="Environment">Environment</option>
                                        <option value="Health">Health</option>
                                    </select>
                                </div> <!-- form group [rows] -->
                                <div class="form-group">
                                    <label class="filter-col" for="locationSearch">Near:</label>
                                        <input type="text" name="locationSearch" class="form-control input-lg" id="locationSearch" placeholder="Search cities" required>
                                        <div class="col-xs-12">
                                            <ul class="center-block" id="suggestion-box">
                                                <li id="beforeSearchText"><i>Search for a city</i></li>
                                            </ul>
                                        </div>
                                        <button id="searchButton" class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                                </div><!-- form group [search] -->
                            </form>

                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div id="categoriesWrapper" class="container">
    <h1>Select a category</h1>

    <div class="row eventsWrapper">
        <div class="">


        <a href="categories/outdoors"><div class="col-sm-2 col-xs-6  categories">
            <img src="images/outdoors.svg" class="img-responsive center-block">
            <h3>Outdoors</h3>
        </div></a>
        <a href="categories/sports"><div class="col-sm-2 col-xs-6 categories">
            <img src="images/sports.svg" class="img-responsive center-block">
            <h3>Sports</h3>
        </div></a>
        <a href="categories/gaming"><div class="col-sm-2 col-xs-6 categories">
            <img src="images/controller.svg" class="img-responsive center-block">
            <h3>Gaming</h3>
        </div></a>
        <a href="categories/music"><div class="col-sm-2 col-xs-6 categories">
            <img src="images/music.svg" class="img-responsive center-block">
            <h3>Music</h3>
        </div></a>
        <a href="categories/Movies"><div class="col-sm-2 col-xs-6 categories">
            <img src="images/movies.svg" class="img-responsive center-block">
            <h3>Movies</h3>
        </div></a>
        <a href="categories/food"><div class="col-sm-2 col-xs-6 categories">
            <img src="images/food.svg" class="img-responsive center-block">
            <h3>Food & Dining</h3>
        </div></a>
        <a href="categories/programming"><div class="col-sm-2 col-xs-6 categories">
            <img src="images/code.svg" class="img-responsive center-block">
            <h3>Programming</h3>
        </div></a>
        <a href="categories/politics"><div class="col-sm-2 col-xs-6 categories">
            <img src="images/politics.svg" class="img-responsive center-block">
            <h3>Politics</h3>
        </div></a>
        <a href="categories/environment"><div  class="col-sm-2 col-xs-6 categories">
            <img src="images/earth.svg" class="img-responsive center-block">
            <h3>Environment</h3>
        </div></a>
        <a href="categories/health"><div class="col-sm-2 col-xs-6 categories">
            <img src="images/health.svg" class="img-responsive center-block">
            <h3>Health</h3>
        </div></a>
    </div>
    </div>
</div>


<?php

include('footer.php');

