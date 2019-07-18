function typeChange(e)
{
    var site = e.getAttribute('site');
    var type = e.value;
    if(type === 'all')
    {
        window.location.href = '/' + site;
    }
    else
    {
        window.location.href = '/' + site + '/' + type;
    }
}