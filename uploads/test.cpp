#include<iostream>
#include<cstring>
#include<cstdio>
using namespace std;
int main()
{
    char s[100000],a[100000];
    long long int i,j,n,c;
    while(gets(s))
    {
        if(strcmp(s,"DONE")==0)break;
        c=1;
        for(i=0,j=0;i<strlen(s);i++)
        {
            if((s[i]>='A'&&s[i]<='Z') || (s[i]>='a'&&s[i]<='z'))
            {
                a[j]=s[i];
                j++;
            }
        }
        n=j;
        a[n]='\0';
        for(i=0,j=n-1;;j--,i++)
        {
            if(i>j)break;
            if(a[i]>='A'&&a[i]<='Z')a[i]=a[i]+32;
            if(a[j]>='A'&&a[j]<='Z')a[j]=a[j]+32;
            if(a[i]!=a[j])
            {
                c=0;
                break;
            }
        }

        if(c==0)printf("Uh oh..\n");
        else printf("You won't be eaten!\n");
    }
    return 0;
}
