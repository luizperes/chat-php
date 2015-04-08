

// calls every 1 second the event :)
function timedCount() 
{
    postMessage("");
    setTimeout("timedCount()", 1000);
}

timedCount();