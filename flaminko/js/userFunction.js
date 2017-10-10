function init() {
            //Parameters are APIName,APIVersion,CallBack function,API Root 
			//do not forget to modify the URL below that contain your Project ID
            gapi.client.load('usersendpoint', 'v1', null, 'https://flaminko-in-the-cloud-api.appspot.com/_ah/api');
            
            document.getElementById('listUsers').onclick = function() {
                listUsers();
              }
            
            document.getElementById('registerUser').onclick = function() {
                    insertUsers();
            }
            
            document.getElementById('updateUser').onclick = function() {
                    updateUsers();
            }
            
            document.getElementById('removeUsers').onclick = function() {
                    removeUsers();
            }
    }
    
//List Users function that will execute the listQuote call
function listUsers() {
		document.getElementById('listUsersResult').innerHTML = "Wait..........";
        gapi.client.usersendpoint.listUsers().execute(function(resp) {
                if (!resp.code) {
                        resp.items = resp.items || [];
                        var result = "<div class='datagrid'><table><tr><th>User Id</th><th>Username</th><th>Password</th><th>Name</th><th>Email</th><th>Credit</th><th>Admin</th></tr>";
                        for (var i=0;i<resp.items.length;i++) {                                        
								result = result+ "<tr><td>" + resp.items[i].id + "</td><td>" + resp.items[i].userName + "</td><td>" +  resp.items[i].password +  "</td><td>" +  resp.items[i].name +  "</td><td>" +  resp.items[i].email +  "</td><td>" +  resp.items[i].credit +  "</td><td>" +  resp.items[i].admin +  "</td></tr>";
                        }
						result = result + "</table></div>";
                        document.getElementById('listUsersResult').innerHTML = result;
                }
        });
}

//Insert User function
function insertUsers() {
        //Validate the entries
        var _Username = document.getElementById('username').value;
        var _Password = document.getElementById('password').value;
		var _Name = document.getElementById('name').value;
		var _Email = document.getElementById('email').value;
		var _Credit = document.getElementById('credit').value;
		if(document.getElementById('rt').checked == true){
			var _Admin = document.getElementById('rt').value;
		}
		if(document.getElementById('rf').checked == true){
			var _Admin = document.getElementById('rf').value;
		}
        
        //Build the Request Object
        var requestData = {};
        requestData.userName = _Username;
        requestData.password = _Password;
		requestData.name = _Name;
		requestData.email = _Email;
		requestData.credit = _Credit;
		requestData.admin = _Admin;
		
        gapi.client.usersendpoint.insertUsers(requestData).execute(function(resp) {
                if (!resp.code) {
                        //Just logging to console now, you can do your check here/display message
                        console.log(resp.id + ":" + resp.userName + ":" + resp.password + ":" + resp.name + ":" + resp.email + ":" + resp.credit + ":" + resp.admin);
						document.getElementById('username').value = "";
						document.getElementById('password').value = "";
						document.getElementById('name').value = "";
						document.getElementById('email').value = "";
						document.getElementById('credit').value = "";
						document.getElementById('rt').checked = "false";
						document.getElementById('rt').checked = "false";
						alert('User Registered');
						listUsers();
                }
        });
}

//Update User function
function updateUsers() {
	var _UserID = document.getElementById('edituserID').value;
	var _editUserName = document.getElementById('editUsername').value;
	var _editPassword = document.getElementById('editPassword').value;
	var _editName = document.getElementById('editName').value;
	var _editEmail = document.getElementById('editEmail').value;
	var _editCredit = document.getElementById('editCredit').value;
	if(document.getElementById('editRt').checked == true){
		var _editAdmin = document.getElementById('editRt').value;
	}
	if(document.getElementById('editRf').checked == true){
		var _editAdmin = document.getElementById('editRf').value;
	}
	
	var requestData = {};
    requestData.id = _UserID;
	requestData.userName = _editUserName;
    requestData.password = _editPassword;
	requestData.name = _editName;
	requestData.email = _editEmail;
	requestData.credit = _editCredit;
	requestData.admin = _editAdmin;
	
	gapi.client.usersendpoint.updateUsers(requestData).execute(function(resp){
		if (!resp.code) {
			//Just logging to console now, you can do your check here/display message
			console.log(resp.id + ":" + resp.author + ":" + resp.message);
			document.getElementById('edituserID').value = "";
			document.getElementById('editUsername').value = "";
			document.getElementById('editPassword').value = "";
			document.getElementById('editName').value = "";
			document.getElementById('editEmail').value = "";
			document.getElementById('editCredit').value = "";
			document.getElementById('editRt').checked = "false";
			document.getElementById('editRf').checked = "false";
			alert('User Updated');
			listUsers();
		}
	});
}

//Remove USer function
function removeUsers() {
	var _UserID = document.getElementById('userID').value;
	
	var requestData = {};
    requestData.id = _UserID;
	gapi.client.usersendpoint.removeUsers(requestData).execute(function(resp){
		document.getElementById('userID').value = "";
		alert('User Deleted');
		listUsers();
	});
}