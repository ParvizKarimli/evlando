function typeChange(e)
{
    var type = e.value;
    if(type === 'all')
    {
        window.location.href = '/posts';
    }
    else
    {
        window.location.href = '/posts/' + type;
    }
}