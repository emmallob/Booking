var loggedInUser = Cookies.get("loggedInUser");
(loggedInUser !== undefined) ? $(`span[class="loggedInUser"]`).html(loggedInUser): null;