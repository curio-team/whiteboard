$(document).ready(function() { 
    let intervalTijd = 15000; // 15 sec
    setInterval(timerRun, intervalTijd);
});


function timerRun()
{    
    $.ajax({
        type:   "POST",
        url:    "app/timer",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done( (response) => {
        printer(convertToArray(response))
    });
}

function printer(data)
{
    const time = 0;
    const name = 1;
    const id = 2;
    const description = 3;
    const removeButton = 4;

    for (let i = 0;i < data.length;i++)
    {
        let temp = i + 1;
        let updateBox = document.getElementById("category-" + temp);
        let innerHTMLBox;

        for (let j = data[i].length - 1;j >= 0;j--)
        {
            innerHTMLBox =  ((innerHTMLBox == null) ? "" : innerHTMLBox )
                            +    "<li id=\"category-"+temp+"-user-"+data[i][j][id]+"\">"
                            +   "<span class=\"time\">"+data[i][j][time]+"</span>"
                            +   data[i][j][name]
                            +   ((data[i][j][description] == "null")? "" : " (" + data[i][j][description]+")")
                            +   ((data[i][j][removeButton] == "true")? "<a class=\"pull-right glyphicon glyphicon-remove\" href=\"/signoff/user/"+data[i][j][id]+"/category/"+temp+"\"></a>" : "")
                            +   "</li>";
        }
        updateBox.innerHTML = innerHTMLBox;
    }
}

function convertToArray(data)
{
    const rowEnd = ";";
    const columnEnd = "+";
    const catEnd = "@";
    let arrayFromString;

    arrayFromString = data.split(catEnd);

    for (let i = 0;i < arrayFromString.length;i++)
    {
        arrayFromString[i] = arrayFromString[i].split(rowEnd)
        for (let j = 0; j < arrayFromString[i].length; j++)
        {
            arrayFromString[i][j] = arrayFromString[i][j].split(columnEnd); 
        }
    }

    return arrayFromString;
}