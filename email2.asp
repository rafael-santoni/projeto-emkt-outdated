<%@ LANGUAGE="vbscript"%>
<%
dim emailTo(3), i

emailTo(0) = "Rafa <emaildorafa@gmx.com>"
emailTo(1) = "Teane <te.araujo88@gmail.com>"
emailTo(2) = "Consultora Jequiti <jequiti.limeira@gmail.com>"
emailTo(3) = "rafael.pulze@hotmail.com"

strNome = "nome" 'Request.Form("nome")
strMail = "mail@mailing.com" 'Request.Form("email")

Set objCDO      = Server.CreateObject("CDO.Message") 
Set objCDOConf  = Server.CreateObject("CDO.Configuration") 
	With objCDOConf.Fields 
		.Item("http://schemas.microsoft.com/cdo/configuration/sendusing") = 2 
		.Item("http://schemas.microsoft.com/cdo/configuration/smtpserver") = "mail.rafasantoni.heliohost.org" 
		.Item("http://schemas.microsoft.com/cdo/configuration/smtpserverport") = 25 
		.Item("http://schemas.microsoft.com/cdo/configuration/smtpauthenticate") = 1 
		.Item("http://schemas.microsoft.com/cdo/configuration/sendusername") = "autosender@rafasantoni.heliohost.org" 
		.Item("http://schemas.microsoft.com/cdo/configuration/sendpassword") = "sender"
'        .Item(cdoSMTPconnectiontimeout) = 10 
		.Update 
    End With
Set objCDO.Configuration = objCDOConf 
objCDO.From     = "Rafael Santoni - Consultor Imobiliário <santoni@pulze.com.br>"
objCDO.To       = ""
objCDO.Subject  = "email do terrazzo 07/04 - numero 2"
objCDO.HTMLBody = "<center><h2><font color=green>Email de teste</font></h2></center><BR><BR><BR>AGORA com HTML<br><br>Mudei o endereço de email do remetente, antes rafatony.consultor@gmail.com  -  atual: santoni@pulze.com.br<br><br> Numero: <b>2</b>"

For i = 0 to 2
	objCDO.To = emailTo(i)
	On Error Resume Next

	objCDO.Send
   	If Err.Number <> 0 Then
		msg = "<BR>No Ok " & Err.description
	Else
		msg = "<br>Ok - teste numero 2"
	End If
	Response.Write(msg)
next

Set objCDO     = Nothing
Set objCDOConf = Nothing
%>