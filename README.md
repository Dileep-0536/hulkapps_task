Task Name is: PDF Uploaded Test
Technical Requirements: HTML, CSS, Javascript, PHP, Laravel, Mysql, Bootstrap
Technical specifications:
PHP Version: 8
Laravel Version: 9.5
Mysql Version: 10.4.20-MariaDB
Bootstrap Version: 4
---------------------------------------------------------------------------------------------
Guidelines for set up the project in local system:
1.Go to PHP server htdocs folder then open git terminal.
2.Clone the project from the above url.
3.Install composer in terminal.
4.If .env does not existed in project folder so please create .env from .env.example file.
5.Give database credentials as per your mysql database or give the below credendials in .env file.
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hulkapps_task
DB_USERNAME=root
DB_PASSWORD=
6.If application encryption key is not generated so please run generate key command in terminal.
7.Upload db file from db_folder in mysql database.
8.After set the project please go to browser then run the project.
-----------------------------------------------------------------------------------------------
Project Documentation:
1.After run the project in broswer then click on login or register page from header section.
2.If user click on register page the registeration form will open then fill the details after that it will redirected to dashboard page.
3.If you have already credentials please go to login page then enter the details after that it will redirected to dashboard page.
4.After login you have a find a link named with managed fies for showing the list of pdfs.
5.There we have an option called upload button for upload new pdfs.
6.Click on Upload button then form will opened in another page then upload pdf file, select one or more tags then click on create button the pdf file will be uploaded in server then it redirects to manage files list page.
7.In the manage files list page you can find list of uploaded pdfs list in left side. If user ciick on any pdf link then the respctive pdf content will be open in right side. Whatever the user selects or click on the pdf list in left side their respective pdf content will be opened in the right side. After that the particular document name background color will be changed in left side.
8.If user reloads the page last time user selects Document2 then automatically it opens the last opened pdf content in right side.
9.For each pdf we are given the edit pdf. If click on edit button it will redirected to edit form.
10.There we are given the option for uploading new pdf as well as view the existing pdf.
11.If user uploadds the new pdf click on edit buttton automatically the old pdf file will be removed from server then replaced with new file. If user not uploaded any thing so old pdf will be there.
12.Like this way we have options for uploading new pdf file, edit the existing file,selects the random pdfs list, view the selected pdf content in right side.
13.After click on logout button it will redirected to login page.
----------------------------------------------------------------------------------------------
How i approached to project?
1.First i understand the pdfs list design as given in figma url.
2.Depends upon design, as per task specifications i created the required tables.
3.Depend upon requirement maximum i utilized only one controller.
4.First i finished auth login, registration pages as per laravel authentication package.
5.After that i started the uploading new pdf design.
6.After that i started the design the view of pdfs list from left side, ajax click events for view the pdf content at right side.
7.Final part is edit is done then completed the validation part for all forms.
Note:
1.As per design i completed the everything. I given the options for new uploaded file for seperate page as well as for edit part also i given seperate page.
2.I am giving the uploading size option is 20MB.
----------------------------------------------------------------------------------------------
What i am liked in this project personally?
1.Beauty of pdfs list design
2.View the selected pdf content from particular pdf list click event.
Project Estimation time: Approximate 12 to 16 hours.
I think there is no pending from my side as per design i finished the task.
----------------------------------------------------------------------------------------------
Problems i faced:
1.Personally i faced the post related url issue when hit the url in browser. This one is not resolved.
2.Validation part is done for all forms only one thing is pending like when we select the empty tags in edit part i am unable to old tags. I have to refresh the page. This is the issue.