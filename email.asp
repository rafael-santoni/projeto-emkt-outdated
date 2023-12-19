<%@ LANGUAGE="vbscript"%>


				<OBJECT RUNAT=SERVER PROGID="Persits.MailSender" ID="Mail">
				</OBJECT>
<%
				' ######### inicio envio de email #########


				p_email = "emaildorafa@gmx.com"
				DIM var(3), i
				var(0) = "te.araujo88@gmail.com"
				var(1) = "emaildorafa@gmx.com"
				'var(2) = "aldasantoni@gmail.com"
				'var(3) = "santoni.ac@gmail.com"


					
				set arrTo = Session("arrTo")
				'response.write " ""tt"" <BR>"

				Mail.Host = "mail.rafasantoni.heliohost.org"
				Mail.Username = "autosender@rafasantoni.heliohost.org"
				Mail.Password = "sender"
				
			for i = 0 to 1
				Mail.AddAddress var(i)
				Mail.From = "rafatony.consultor@gmail.com"
				Mail.FromName = "Rafael da PULZE"
				Mail.Subject = "ate quando E-Mkt"
				
				p_body = "Olá, <br> quantidade de pessoas no email<BR><BR><BR><HR><BR><BR><BR> email automatico<BR><BR><BR><BR><font color=red>Não responda</font>."
				
				Mail.Body = p_body
				Mail.IsHTML = True
				
				On Error Resume Next
				if not Mail.Send then
					Response.Write "<br>Não foi possivel enviar para : " & var(i) & " -> "
					Response.Write Err.Description
				else
					Response.Write "<BR> <b>Email enviado para " & var(i) & "</B> "
					arrTo.RemoveAll
				end if
				On Error Goto 0
				' ######### FIM do envio de email #########

			Next
%>
