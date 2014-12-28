Solution

.Firstly, open a .csv file in read mode by using fopen function in php.
2.Then two arrays is created:
-$awards[] that contains awards.csv data
-$contracts[] that contains contracts.csv data
3.Using for loop set counter to differentiate header column and value column
4.If header is contractname merge the data of two .csv file of that column
5.Add new field header latlon 
6.For non-header column then merge the content using arrary_merge method
7.Using request_url and xml online data is parsed and particular latitude and longitude is figured out 
8.Lastly,write to final.csv with combined data.

