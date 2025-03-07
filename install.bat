@echo off
REM =============================================
REM         +----------------------------------+
REM         |   V   I   D   E   O   F   O   R   G   E   |
REM         +----------------------------------+
REM =============================================
echo.
echo +--------------------------------------------------+
echo ^|   V   I   D   E   O   F   O   R   G   E          ^|
echo +--------------------------------------------------+
echo.

REM Aguarda 1 segundos
timeout /t 1 >nul

echo Iniciando instalacao do VideoForge...
echo.

REM Simula uma tela de carregamento
setlocal EnableDelayedExpansion
set "loadingText=Carregando"
for /l %%i in (1,1,3) do (
    set "dots="
    for /l %%j in (1,1,%%i) do set "dots=!dots!."
    cls
    echo +--------------------------------------------------+
    echo ^|   V   I   D   E   O   F   O   R   G   E          ^|
    echo +--------------------------------------------------+
    echo.
    echo Iniciando instalacao do VideoForge...
    echo.
    echo !loadingText!!dots!
    timeout /t 1 >nul
)
endlocal

REM Define os caminhos relativos para o .env.example e o .env dentro da pasta docker
set "ENV_EXAMPLE=docker\.env.example"
set "ENV_DEST=docker\.env"

echo.
echo Verificando se "%ENV_EXAMPLE%" existe...
if not exist "%ENV_EXAMPLE%" (
    echo ERRO: "%ENV_EXAMPLE%" nao encontrado. Verifique se o arquivo existe na pasta "docker".
    echo.
    pause
    exit /b 1
)
echo.
echo Verificando se "%ENV_DEST%" ja existe...
echo.
if exist "%ENV_DEST%" (
    echo O arquivo %ENV_DEST% ja existe. Nenhuma acao foi tomada.
    echo.
) else (
    echo Criando o arquivo %ENV_DEST% a partir de %ENV_EXAMPLE%...
    echo.
    copy "%ENV_EXAMPLE%" "%ENV_DEST%"
    if %errorlevel% equ 0 (
        echo %ENV_DEST% criado com sucesso.
        echo.
    ) else (
        echo Ocorreu um erro ao criar o arquivo %ENV_DEST%.
        echo.
    )
)

pause
