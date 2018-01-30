// Javascript file for form
function validate()
{
    var eve = document.forms["add-events"]["eventname"].value;
    var loc = document.forms["add-events"]["location"].value;
    var regex = /^[0-9a-zA-Z]+$/;
    if (eve.match(regex) && loc.match(regex))
    {
      return true;
    }
    else
    {
      alert('EventName & Location must be in alphanumeric character only');
       return false;
    }
}
