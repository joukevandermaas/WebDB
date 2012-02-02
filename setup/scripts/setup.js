var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Msxml2.XMLHTTP");
var message;
var title;
var orgList;
var orgListIndex;
var loadedCount;
var loading;

function doRequest(url, callback) {
    request.open("GET", url, true);
    request.onreadystatechange = function() { requestFinish(callback); };
    request.send(null);
}
function requestFinish(callback) {
    if (request.readyState == 4 && request.status == 200) {
//        alert(request.responseText);
        var response = JSON.parse(request.responseText);
        callback(response);
    }
}
function setMessage(t, m) {
    title = title == null ? document.getElementById('title') : title;
    message = message == null ? document.getElementById('message') : message;
    
    title.innerHTML = (loading ? "<img src='loading.gif' alt='' />" : '') + t;
    message.innerHTML = m;
}

function startSetup() {
    loading = true;
    doRequest('testconnection.php', testConnectionFinish);
}
function setupTables() {
    doRequest('setuptables.php', setupTablesFinish);
}
function loadHodexList() {
    doRequest('loadhodexlist.php', loadHodexListFinish);
}
function loadHodexOrg() {
    if (orgListIndex < orgList.length) {
        var url = encodeURIComponent(orgList[orgListIndex].url);
        doRequest('loadhodexorg.php?id=' + orgList[orgListIndex].id + '&url=' + url, loadHodexOrgFinish);
    } else {
        finishSetup();
    }
}
function finishSetup() {
    loading = false;
    setMessage('Setup - Klaar', 'Het opzetten van de database is voltooid. Vergeet niet de /setup directory te verwijderen!');
}

function testConnectionFinish(response) {
    if (!response.succes) {
        setMessage('Setup - Fout', 'Er kan geen verbinding worden gemaakt met de database. Controleer de waarden in tools/settings.php');
    } else {
        setMessage('Setup - Aanmaken tabellen', 'Er is verbinding met de database. Tabellen worden aangemaakt...');
        setupTables();
    }
}
function setupTablesFinish(response) {
    if (!response.succes) {
        setMessage('Setup - Fout', 'De tabellen kunnen niet worden aangemaakt. Controleer of de databaseserver goed is geconfigureerd.');
    } else {
        setMessage('Setup - Inladen hodexinformatie', 'De tabellen zijn aangemaakt. De hodexinformatie wordt ingeladen (dit kan 10 minuten duren)...');
        loadHodexList();
    }
}
function loadHodexListFinish(response) {
    if (!response.succes) {
        setMessage('Setup - Fout', 'De hodexinformatie kon niet worden ingelezen en verwerkt');
    } else {
        orgList = response.orgs;
        orgListIndex = 0;
        loadedCount = 0;
        loadHodexOrg();
    }
}
function loadHodexOrgFinish(response) {
    if (!response.succes) {
        setMessage('Setup - Fout', 'De hodexinformatie kon niet worden ingelezen en verwerkt');
    } else {
        orgListIndex++;
        loadedCount += response.loaded;
        setMessage('Setup - Inladen hodexinformatie', 'Er zijn ' + loadedCount + ' studies ingeladen...');
        loadHodexOrg();
    }
}
