// Holds each relevant DOM element
const El = 
{
    login: document.getElementById('login'),
    mainContent: document.getElementById("mainContent"),
    dataBox: document.getElementById('dataBox'),
    aside: document.getElementsByTagName('aside')[0],
    tabs: document.getElementsByClassName('tablink'),
    tabPages: document.getElementsByTagName('article')
}


//
// LOGIN METHODS
//
function hideLogin()
{
    El.login.style.display = 'none';
}

//
// TRANSITION FROM LOGIN TO MAIN CONTENT
//
function activateMainContent()
{
    hideLogin();

    // Allow tabs to be clicked
    El.aside.addEventListener("click", clickTab);

    // Have the first page and tab be active
    activateTabPage(0);
}

//
// TAB METHODS
//
function resetTabs()
{
    for (var tab of El.tabs)
    {
        console.log(tab);
        tab.classList.remove("activeTab");
    }
}
function hideAllTabPages()
{
    for (var page of El.tabPages)
    {
        console.log(page);
        page.classList.add("hidden");
    }
}
function activateTabPage(tabIndex)
{
    hideAllTabPages();
    resetTabs();
    El.tabs[tabIndex].classList.add("activeTab");
    El.tabPages[tabIndex].classList.remove("hidden");
}

 /**
  * Checks which tab was clicked and shows its corresponding page.
  * Called when a tab is clicked.
  * 
  * @param {event} event  
  */
function clickTab(event)
{
    const clickedTab = event.target;
    // Convert to normal array to use indexOf method
    const tabs = [...El.tabs];
    let tabIndex = tabs.indexOf(clickedTab);

    // Check if clicked area is a valid tab
    if (tabIndex > -1)
    {
        activateTabPage(tabIndex);
    }
}


//
// GAME DATA METHODS
//
function createDataRow(title, plays, revenue)
{
    // Base container
    var dRow = document.createElement("data-row");

    var data = [title, plays, revenue];
    for (var datum of data)
    {
        var p = document.createElement("p");
        p.innerText = datum;
        dRow.appendChild(p);
        console.log(datum);
    }

    El.dataBox.appendChild(dRow);
}
function createTotalRow(plays, revenue)
{
    // Base container
    var dRow = document.createElement("data-row");

    var data = ["Total", plays, "$" + revenue];
    for (var datum of data)
    {
        var h = document.createElement("h3");
        h.innerText = datum;
        dRow.appendChild(h);
        console.log(datum);
    }
    El.dataBox.appendChild(dRow);
}

