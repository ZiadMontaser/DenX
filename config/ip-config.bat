FOR /F "tokens=*" %%F IN ('ipconfig ^| find "Default Gateway"') DO (SET var=%%F)
SET "var=%var:*: =%"
SET "var1=23"
SET "var1=%var%%var1%"
netsh interface ipv4 set address name="Wi-Fi" static %var1% 255.255.255.0 %var%
pause
endlocal 
