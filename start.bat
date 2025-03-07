@echo off
cd /D %~dp0
call venvvideoforge\Scripts\activate
python main.py
pause
