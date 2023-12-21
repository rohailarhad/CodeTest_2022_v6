I have reviewed the code of BookingController and BookingRepository, here are my observations:

1) In BookingController, we should use Request Class for each request passing to function to validate so that there is less errors, Rest of the code is seems ok to me. one extra optional optimization could have been done is that we can remove extra line spacing to reduce the file size, so it take less space and load quickly.

2) BaseRepository code is clean, ok, simple, easy to understand and use.

3) I have created test cases for both function and attached the file. tests\Unit\ExampleTest.php