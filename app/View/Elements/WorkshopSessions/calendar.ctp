<?php echo $this->Html->script('basiccalendar')?><form>
<select onChange="updatecalendar(this.options)">
<script type="text/javascript">

var themonths=['January','February','March','April','May','June',
'July','August','September','October','November','December']

var todaydate=new Date()
var curmonth=todaydate.getMonth()+1 //get current month (1-12)
var curyear=todaydate.getFullYear() //get current year

function updatecalendar(theselection){
var themonth=parseInt(theselection[theselection.selectedIndex].value)+1
var calendarstr=buildCal(themonth, curyear, "main", "month", "daysofweek", "days", 0)
if (document.getElementById)
document.getElementById("calendarspace").innerHTML=calendarstr
}

document.write('<option value="'+(curmonth-1)+'" selected="yes">Current Month</option>')
for (i=0; i<12; i++) //display option for 12 months of the year
document.write('<option value="'+i+'">'+themonths[i]+' '+curyear+'</option>')


</script>
</select>

<div id="calendarspace">
<script>
//write out current month's calendar to start
document.write(buildCal(curmonth, curyear, "main", "month", "daysofweek", "days", 0))
</script>
</div>

</form>