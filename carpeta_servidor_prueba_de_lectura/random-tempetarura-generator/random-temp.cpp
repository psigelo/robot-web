#include <iostream>
#include <fstream>
#include <cstdlib>
#include <unistd.h>
#include <string>

using namespace std;

int main()
{
	do
	{
		ofstream archivo;
		archivo.open("../temperatura", ios::trunc);
		archivo << rand() % 150 + -30 << "	";
		archivo << rand() % 150 + -30 << "	";
		archivo << rand() % 150 + -30 << "	";
		archivo << rand() % 150 + -30 << "	";
		archivo << rand() % 150 + -30 << "	";
		archivo << rand() % 150 + -30;
		archivo.close();
		sleep(1);
	} while (1);
	
	return 0;
}