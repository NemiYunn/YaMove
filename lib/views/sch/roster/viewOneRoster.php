<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <!-- card -->
        <div class="card text-dark bg-light border-info">
            <div class="card-header">
                Roster &nbsp;
                <input type="text" id="rosId" name="rosId" value="<?php echo ($_GET['rosId']); ?>" readonly>
            </div>
            <div class="card-body">
                <!-- bootstrap form -->
                <form id="addRosForm">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Emp Id</label>
                        <input type="text" class="form-control" id="empId" name="empId" placeholder="Enter Employee Id" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Year</label>
                        <input type="text" class="form-control" name="datepicker" id="datepicker" readonly />
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="exampleFormControlSelect1">Month</label>
                        <select class="form-control" id="month" name="month" disabled>
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
                        </select>
                    </div>
                    <Br>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Day 01</div>
                                </div>
                                <input type="text" class="form-control" id="day1" name="day1" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Day 02</div>
                                </div>
                                <input type="text" class="form-control" id="day2" name="day2" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Day 03</div>
                                </div>
                                <input type="text" class="form-control" id="day3" name="day3" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Day 04</div>
                                </div>
                                <input type="text" class="form-control" id="day4" name="day4" readonly>
                            </div>
                        </div>
                    </div>
                    <Br>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Day 05</div>
                                </div>
                                <input type="text" class="form-control" id="day5" name="day5" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Day 06</div>
                                </div>
                                <input type="text" class="form-control" id="day6" name="day6" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Day 07</div>
                                </div>
                                <input type="text" class="form-control" id="day7" name="day7" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Day 08</div>
                                </div>
                                <input type="text" class="form-control" id="day8" name="day8" readonly>
                            </div>
                        </div>
                    </div>
                    <Br>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Day 09</div>
                                </div>
                                <input type="text" class="form-control" id="day9" name="day9" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Day 10</div>
                                </div>
                                <input type="text" class="form-control" id="day10" name="day10" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Day 11</div>
                                </div>
                                <input type="text" class="form-control" id="day11" name="day11" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Day 12</div>
                                </div>
                                <input type="text" class="form-control" id="day12" name="day12" readonly>
                            </div>
                        </div>
                    </div>
                    <Br>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Day 13</div>
                                </div>
                                <input type="text" class="form-control" id="day13" name="day13" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Day 14</div>
                                </div>
                                <input type="text" class="form-control" id="day14" name="day14" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Day 15</div>
                                </div>
                                <input type="text" class="form-control" id="day15" name="day15" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Day 16</div>
                                </div>
                                <input type="text" class="form-control" id="day16" name="day16" readonly>
                            </div>
                        </div>
                    </div>
                    <Br>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Day 17</div>
                                </div>
                                <input type="text" class="form-control" id="day17" name="day17" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Day 18</div>
                                </div>
                                <input type="text" class="form-control" id="day18" name="day18" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Day 19</div>
                                </div>
                                <input type="text" class="form-control" id="day19" name="day19" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Day 20</div>
                                </div>
                                <input type="text" class="form-control" id="day20" name="day20" readonly>
                            </div>
                        </div>
                    </div>
                    <Br>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Day 21</div>
                                </div>
                                <input type="text" class="form-control" id="day21" name="day21" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Day 22</div>
                                </div>
                                <input type="text" class="form-control" id="day22" name="day22" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Day 23</div>
                                </div>
                                <input type="text" class="form-control" id="day23" name="day23" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Day 24</div>
                                </div>
                                <input type="text" class="form-control" id="day24" name="day24" readonly>
                            </div>
                        </div>
                    </div>
                    <Br>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Day 25</div>
                                </div>
                                <input type="text" class="form-control" id="day25" name="day25" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Day 26</div>
                                </div>
                                <input type="text" class="form-control" id="day26" name="day26" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Day 27</div>
                                </div>
                                <input type="text" class="form-control" id="day27" name="day27" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Day 28</div>
                                </div>
                                <input type="text" class="form-control" id="day28" name="day28" readonly>
                            </div>
                        </div>
                    </div>
                    <Br>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Day 29</div>
                                </div>
                                <input type="text" class="form-control" id="day29" name="day29" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Day 30</div>
                                </div>
                                <input type="text" class="form-control" id="day30" name="day30" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Day 31</div>
                                </div>
                                <input type="text" class="form-control" id="day31" name="day31" readonly>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row mt-3">
                        <div class="col-md-9">
                            <button class="btn btn-primary no-print" id="btn_back" style="position:absolute; left:10px;bottom:10px;"> Back </button>
                        </div>
                        <div class="col-md-3">
                            <!-- <input type="submit" value="submit" class="btn btn-primary" id="saveRoster"> &nbsp; &nbsp;
                            <button type="reset" class="btn btn-secondary reset">Reset</button> -->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        function fetchView() {
            var rosId = $("#rosId").val();
            // pass to the route and get the data
            $.ajax({
                url: "../routes/roster/fetchRoster.php",
                method: "POST",
                data: {
                    rosId: rosId
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    // $sch = json_decode(data.schedules,true);
                    // console.log($sch['01']);
                    $("#empId").val(data.empId);
                    $("#datepicker").val(data.years);
                    $("#month").val(data.months);
                    $("#day1").val(data.day1);
                    $("#day2").val(data.day2);
                    $("#day3").val(data.day3);
                    $("#day4").val(data.day4);
                    $("#day5").val(data.day5);
                    $("#day6").val(data.day6);
                    $("#day7").val(data.day7);
                    $("#day8").val(data.day8);
                    $("#day9").val(data.day9);
                    $("#day10").val(data.day10);
                    $("#day11").val(data.day11);
                    $("#day12").val(data.day12);
                    $("#day13").val(data.day13);
                    $("#day14").val(data.day14);
                    $("#day15").val(data.day15);
                    $("#day16").val(data.day16);
                    $("#day17").val(data.day17);
                    $("#day18").val(data.day18);
                    $("#day19").val(data.day19);
                    $("#day20").val(data.day20);
                    $("#day21").val(data.day21);
                    $("#day22").val(data.day22);
                    $("#day23").val(data.day23);
                    $("#day24").val(data.day24);
                    $("#day25").val(data.day25);
                    $("#day26").val(data.day26);
                    $("#day27").val(data.day27);
                    $("#day28").val(data.day28);
                    $("#day29").val(data.day29);
                    $("#day30").val(data.day30);
                    $("#day31").val(data.day31);

                }
            })
        }
        fetchView();

        $(document).on("click", "#btn_back", function() {
            $("#root").load('sch/chooseScheduleTask.php');
        })

    })
</script>