// global
var wWorker;
var nameUser;
var lastCounter = 0;

$(document).ready(function()
{
	// ask the name of the user
	getNameUser();
	initVars();

	$("#btnMessage").click(function()
	{
		request("send", $("#message").val());
	});

	// starting worker
	initWebWorker();
});

function initVars()
{
}

function getNameUser()
{
	nameUser = prompt("Please enter your name");
	if (nameUser == "" || nameUser === "undefined")
		nameUser = "unknown";
}

function initWebWorker()
{
	if(typeof(Worker) !== "undefined")
	{
	    if(typeof(wWorker) == "undefined") {
            wWorker = new Worker("worker.js");
        }

        wWorker.onmessage = function(event) 
        {
        	request("get", "");
        };
	} 
	else 
	{
	    alert("Thread will not work");
	}
}

function request(action, msg)
{
	$.post( "code.php", { name: nameUser, type: action, message: msg, counter: lastCounter })
  	.done(function( data ) 
  	{	
  		handleMessage(action, data);
  	})
  	.fail(function(error) 
  	{
    	alert("Something went wrong");
    	console.log(error);
  	});
}

function handleMessage(action, data)
{
	if (action == "send")
	{
		clearForm();
	}
	else if (action == "get")
	{
		setTextArea(data);
	}	
}

function setTextArea(data) 
{
	var response = JSON.parse(data);
	lastCounter = response.lastCounter;
	var msgs = "";
	for (var i = 0; i < response.messages.length; i++)
	{
		msgs += response.messages[i].user + ": " + response.messages[i].value + "\n";
	}

	$("#mainTextArea").append(msgs);
	$("#mainTextArea").scrollTop($("#mainTextArea")[0].scrollHeight);
}

function clearForm()
{
	$("#message").val("");
}