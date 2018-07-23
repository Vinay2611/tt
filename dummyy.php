<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<%Option Explicit%>

<!-- #INCLUDE VIRTUAL = "Includes/Constants.asp" -->
<!-- #INCLUDE VIRTUAL = "Includes/Functions.asp" -->
<!-- #INCLUDE VIRTUAL = "Includes/DBFunctions.asp" -->

<%

'Declare the variables needed
Dim rsTestDetails, TestID, TestText, TypedText, TransactionID, TestDuration, TestTime, I, SourceArray, TestArray, wordsCorrect, wordsExtra, wordsIncorrect, wordsSkipped, wordsIncorrectTotal, wordsTotal, charIncorrect, wordExpected, wordPrevious, wordCurrent, wordNext, x, y, SourceCounter, TestCounter, prevFlag, Action(), CPMUncorrected, WPMUncorrected, WPMCorrect, Accuracy, rs, ResultID, rsResults, ResultsTotal, ResultsSlab1, ResultsSlab2, ResultsSlab3, ResultsSlab4, ResultsSlab5



Sub CheckTest(txtSource, txtTyped)
wordsExtra = 0
wordsIncorrect = 0
wordsSkipped = 0
wordsCorrect = 0
x = 0
TestCounter = 0
prevFlag = False

txtSource = txtSource & " ."
txtTyped = txtTyped & " ."

txtTyped = Replace(txtTyped, "  ", " ")
txtTyped = Replace(txtTyped, "   ", " ")
SourceArray = Split(txtSource, " ")
TestArray = Split(txtTyped, " ")

If UBound(SourceArray) > 0 Then
ReDim Action(UBound(SourceArray))
Else
ReDim Action(1)
End If

Action(x) = 0

For SourceCounter = 0 To UBound(SourceArray)
If TestCounter >= UBound(TestArray) Then Exit For

y = SourceCounter
wordExpected = SourceArray(SourceCounter)
wordNext = ""
wordCurrent = ""
wordPrevious = ""

If UBound(TestArray) > TestCounter Then wordNext = TestArray(TestCounter + 1)
If UBound(TestArray) >= TestCounter Then wordCurrent = TestArray(TestCounter)
If TestCounter > 0 Then wordPrevious = TestArray(TestCounter - 1)

CheckWord wordExpected, wordCurrent, wordNext, wordPrevious

TestCounter = TestCounter + 1
x = x + 1
Next

If wordsCorrect > 0 Then wordsCorrect = wordsCorrect - 1

End Sub



Public Sub CheckWord(wordExpected, wordCurrent, wordNext, wordPrevious)
If wordExpected = wordCurrent Then
If x > 0 Then
If Action(x - 1) = 0 Then
wordsIncorrect = wordsIncorrect + 1
Action(x - 1) = 1
End If
End If
Action(x) = 1
wordsCorrect = wordsCorrect + 1
ElseIf wordExpected = wordNext Then
If x > 0 Then
If Action(x - 1) = 0 Then
wordsIncorrect = wordsIncorrect + 1
Action(x - 1) = 1
End If
End If
wordsExtra = wordsExtra + 1
wordsCorrect = wordsCorrect + 1
Action(x) = 1
TestCounter = TestCounter + 1
Else
If x > 0 Then
If Action(x - 1) = 0 Then
If wordExpected = wordPrevious Then
wordsSkipped = wordsSkipped + 1
wordsCorrect = wordsCorrect + 1
Action(x - 1) = 1
Action(x) = 1
TestCounter = TestCounter - 1
y = y - 1
prevFlag = True
Else
wordsSkipped = wordsSkipped + 1
Action(x - 1) = 1
End If
End If
End If
End If
y = y + 1
End Sub


'Check if all required data is available
If Trim(Request.Form("TestTyped")) = "" Then
'Report the error
Session("Message") = "You did not type the test at all. Please return to the previous page and take the test again."
Response.Redirect("Messages.asp")
End If

If Not (Trim(Request.Form("TestTime")) <> "" And Trim(Request.Form("TestID")) <> "") Then
'Report the error
Session("Message") = "All required fields not entered. Please return to the previous page and enter all the required data."
Response.Redirect("Messages.asp")
End If


'Store the required variables
TestID = Trim(Request.Form("TestID"))
TypedText = Trim(Request.Form("TestTyped"))
TestTime = Trim(Request.Form("TestTime"))
TransactionID = Trim(Request.Form("TransactionID"))


'Open the connection to the database
OpenDatabase


'Read the details of the test taken by the user
Set rsTestDetails = DSource.Execute("SELECT [Test ID], [Test Text], [Duration] FROM [Tests] WHERE [Test ID] = '" & TestID & "'")

'Check if there is the test was found
If rsTestDetails.EOF Then
'Report the error
Session("Message") = "Test not found in the database. Cannot proceed with processing."
Response.Redirect("Messages.asp")
End If

'Store the required details
TestText = Trim(rsTestDetails("Test Text"))
TestDuration = Trim(rsTestDetails("Duration"))

'Close the open recordset
rsTestDetails.Close


'=========================
'Start correcting the test
'=========================

Call CheckTest(TestText, TypedText)

wordsIncorrectTotal = CInt(wordsIncorrect) + CInt(wordsExtra) + CInt(wordsSkipped)
wordsTotal = CInt(wordsCorrect) + CInt(wordsIncorrect) + CInt(wordsExtra) + CInt(wordsSkipped)

If wordsTotal = 0 Then wordsTotal = 1

For I = 0 To Len(TypedText)
If Mid(TestText, I+1, 1) <> Mid(TypedText, I+1, 1) Then charIncorrect = charIncorrect + 1
Next

CPMUncorrected=round((Len(TypedText)/TestTime)*60)
WPMUncorrected = round((wordsTotal/TestTime)*60) + round(((wordsTotal/AVGWORDLENGTH)/TestTime)*60)
WPMCorrect = round((wordsCorrect/TestTime)*60) + round(((wordsCorrect/AVGWORDLENGTH)/TestTime)*60)
Accuracy = round((wordsCorrect/wordsTotal)*100)

%>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><!-- InstanceBegin template="/Templates/Visitor Area.dwt.asp" codeOutsideHTMLIsLocked="false" -->
<head>
    <title><% = Title %></title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
    <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-25341921-1']);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

    </script>
    <!-- #INCLUDE VIRTUAL = "Includes/Style.asp" -->
</head>

<body>

<div align="center">
    <center>
        <table border="0" width="760" cellspacing="0" cellpadding="0">
            <%If DisplayBanner Then%>
            <tr>
                <td width="100%" colspan="4" bgcolor="#070E76"><img border="0" src="images/TypingCertificatesHeader.jpg" width="760"></td>
            </tr>
            <%End If%>
            <tr>
                <td width="100%" height="25" colspan="4" bgcolor="#070E76" valign="top" align="right"><!-- #INCLUDE VIRTUAL="TopNav.asp" --></td>
            </tr>
            <tr>
                <td width="200" valign="top" align="left" bgcolor="#EEEEEE">
                    <br>
                    <%
                    If CBool(Session("MemberLoggedIn")) <> True Then
                    %><!-- #INCLUDE VIRTUAL="LeftNav.asp" --><%
                    Else
                    %><!-- #INCLUDE VIRTUAL="Members/LeftNav.asp" --><%
                    End If
                    %>
                    <br>
                    <center><img src="images/typingman.jpg" border="0"></center>
                    <br>
                    <div align="center">
                        <center>
                            <table border="0" width="100%" cellspacing="0" cellpadding="0">
                                <tr class="TableData">
                                    <td width="10%"></td>
                                    <td width="90%" align="left"><a href="<% = DOMAINNAME %>/TellAFriend.asp" class="TableHeading">Tell A Friend</a></td>
                                </tr>
                                <tr class="TableData">
                                    <td width="10%"></td>
                                    <td width="90%" align="left"><a href="<% = DOMAINNAME %>/RelatedLinks.asp" class="TableHeading">Related Links</a></td>
                                </tr>
                                <tr class="TableData">
                                    <td width="10%"></td>
                                    <td width="90%" align="left"><a href="<% = DOMAINNAME %>/ImproveYourSpeed.asp" class="TableHeading">Improve Your Speed</a></td>
                                </tr>
                                <tr class="TableData">
                                    <td width="100%" colspan="2">&nbsp;</td>
                                </tr>
                            </table>
                        </center>
                    </div>
                    <br>
                    <center><img src="images/securesite.jpg" border="0"></center>
                    <br>
                    <br>
                </td>
                <td width="2" valign="top" align="center" bgcolor="#070E76"><img src="images/spacer.gif"></td>
                <td width="8" valign="top" align="center"><img src="images/spacer.gif"></td>
                <td width="550" valign="top" align="justify" class="TableData">
                    <div align="right">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="40%" align="right"><img src="images/bar1.jpg"></td>
                                <td width="60%" background="images/bar2.jpg" align="center" valign="top" height="18" class="TopPricing"><a href="<% = DOMAINNAME %>/Members/StartTest.asp" class="TopPricing">Take test for <font color="#FF0000">$7.85</font></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<% = DOMAINNAME %>/PracticeTest.asp" class="TopPricing">Practice for <font color="#FF0000">free</font></a></td>
                            </tr>
                        </table>
                    </div>
                    <br>
                    <!-- InstanceBeginEditable name="MainContent" -->
                    <p class="ContentHeading">TEST RESULTS</p>
                    <hr>
                    <div align="center">
                        <center>
                            <table border="0" width="100%" cellspacing="0" cellpadding="0">
                                <tr class="TableData">
                                    <td width="100%" colspan="4">Lets see how you performed.</td>
                                </tr>
                                <tr class="TableData">
                                    <td width="180" align="right"><strong>Test Duration</strong></td>
                                    <td width="10" align="center">&nbsp;</td>
                                    <td width="140" align="left"><% = TestTime %> secs</td>
                                    <td width="220" align="left" rowspan="5"><img src="images/smallcertificate.jpg" alt="Sample Certificate" align="absmiddle"></td>
                                </tr>
                                <tr class="TableData">
                                    <td width="180" align="right"><strong>Uncorrected Characters/Min</strong></td>
                                    <td width="10" align="center">&nbsp;</td>
                                    <td width="140" align="left"><% = CPMUncorrected %></td>
                                </tr>
                                <tr class="TableData">
                                    <td width="180" align="right"><strong>Uncorrected Words/Min</strong></td>
                                    <td width="10" align="center">&nbsp;</td>
                                    <td width="140" align="left"><% = WPMUncorrected %></td>
                                </tr>
                                <tr class="TableData">
                                    <td width="180" align="right"><strong>Accuracy</strong></td>
                                    <td width="10" align="center">&nbsp;</td>
                                    <td width="140" align="left"><% = Accuracy %>%</td>
                                </tr>
                                <tr class="TableData">
                                    <td width="180" align="right"><strong>Corrected Total Net Words/Min</strong> </td>
                                    <td width="10" align="center">&nbsp;</td>
                                    <td width="140" align="left"><% = WPMCorrect %></td>
                                </tr>
                                <tr class="TableData">
                                    <td width="100%" align="center" colspan="4">&nbsp;</td>
                                </tr>
                                <tr class="TableData">
                                    <td width="100%" align="center" colspan="4">Your overall performance with respect to other users on TypingCertification.com<br><br>
                                        <%

                                        'Read the count of results
                                        Set rsResults = DSource.Execute("SELECT COUNT(*) AS [Total Records] FROM Results")
                                        ResultsTotal = Trim(rsResults.Fields(0))
                                        rsResults.Close

                                        'Read the count of results less than 30
                                        Set rsResults = DSource.Execute("SELECT COUNT(*) AS [Result Count] FROM Results WHERE (AvgCWPM < 30)")
                                        ResultsSlab1 = Trim(rsResults.Fields(0))
                                        rsResults.Close

                                        'Read the count of results between 30 and 40
                                        Set rsResults = DSource.Execute("SELECT COUNT(*) AS [Result Count] FROM Results WHERE (AvgCWPM > 30) AND (AvgCWPM < 40)")
                                        ResultsSlab2 = Trim(rsResults.Fields(0))
                                        rsResults.Close

                                        'Read the count of results between 40 and 50
                                        Set rsResults = DSource.Execute("SELECT COUNT(*) AS [Result Count] FROM Results WHERE (AvgCWPM > 40) AND (AvgCWPM < 50)")
                                        ResultsSlab3 = Trim(rsResults.Fields(0))
                                        rsResults.Close

                                        'Read the count of results between 50 and 60
                                        Set rsResults = DSource.Execute("SELECT COUNT(*) AS [Result Count] FROM Results WHERE (AvgCWPM > 50) AND (AvgCWPM < 60)")
                                        ResultsSlab4 = Trim(rsResults.Fields(0))
                                        rsResults.Close

                                        'Read the count of results greater than 60
                                        Set rsResults = DSource.Execute("SELECT COUNT(*) AS [Result Count] FROM Results WHERE (AvgCWPM > 60)")
                                        ResultsSlab5 = Trim(rsResults.Fields(0))
                                        rsResults.Close

                                        %>
                                        <table border="0" width="80%" cellspacing="0" cellpadding="2" style="border:1px solid #666666" class="TableData">
                                            <tr c<%If WPMCorrect < 30 Then Response.Write(" style=""background-color:#666666; color:#FFFFFF; font-weight:bold;""") %>>
                                            <td width="20%">&lt;30 WPM</td>
                                            <td width="80%"><div style="width:<% = (CInt(ResultsSlab1)/CInt(ResultsTotal)) * 100 %>%; height:20px; background-color:#000033;"></div></td>
                                            </tr>
                                            <tr <%If WPMCorrect > 30 And WPMCorrect < 40 Then Response.Write(" style=""background-color:#666666; color:#FFFFFF; font-weight:bold;""") %>>
                                            <td width="20%">30-40 WPM</td>
                                            <td width="80%"><div style="width:<% = (CInt(ResultsSlab2)/CInt(ResultsTotal)) * 100 %>%; height:20px; background-color:#003366;"></div></td>
                                            </tr>
                                            <tr <%If WPMCorrect > 40 And WPMCorrect < 50 Then Response.Write(" style=""background-color:#666666; color:#FFFFFF; font-weight:bold;""") %>>
                                            <td width="20%">40-50 WPM</td>
                                            <td width="80%"><div style="width:<% = (CInt(ResultsSlab3)/CInt(ResultsTotal)) * 100 %>%; height:20px; background-color:#006699;"></div></td>
                                            </tr>
                                            <tr <%If WPMCorrect > 50 And WPMCorrect < 60 Then Response.Write(" style=""background-color:#666666; color:#FFFFFF; font-weight:bold;""") %>>
                                            <td width="20%">50-60 WPM</td>
                                            <td width="80%"><div style="width:<% = (CInt(ResultsSlab4)/CInt(ResultsTotal)) * 100 %>%; height:20px; background-color:#0099CC;"></div></td>
                                            </tr>
                                            <tr <%If WPMCorrect > 60 Then Response.Write(" style=""background-color:#666666; color:#FFFFFF; font-weight:bold;""") %>>
                                            <td width="20%">&gt;60 WPM</td>
                                            <td width="80%"><div style="width:<% = (CInt(ResultsSlab5)/CInt(ResultsTotal)) * 100 %>%; height:20px; background-color:#00CCFF;"></div></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr class="TableData">
                                    <td width="100%" align="center" colspan="4">&nbsp;</td>
                                </tr>
                                <tr class="TableData">
                                    <td width="100%" align="center" colspan="4">Practice again, take a certification test or tell your friends about this site.</td>
                                </tr>
                                <tr class="TableData">
                                    <td width="100%" align="center" colspan="4"><input type="button" value="Practice Again" onClick="window.location='/PracticeTest.asp';">&nbsp;&nbsp;&nbsp;<input type="button" value="Take Certification Test" onClick="window.location='/Members/StartTest.asp';">&nbsp;&nbsp;&nbsp;<input type="button" value="Tell A Friend" onClick="window.location='/TellAFriend.asp';"></td>
                                </tr>
                            </table>
                        </center>
                    </div>
                    <!-- InstanceEndEditable -->
                    <br>
                </td>
            </tr>
            <tr class="Menu">
                <td width="100%" height="25" colspan="4" bgcolor="#070E76" valign="middle" align="center">Copyright &copy; <% = Year(Date) %> TypingCertification.Com. All rights reserved. Developed and marketed by <a href="http://carry.website" target="_blank">Carry.Website</a></td>
            </tr>
        </table>
    </center>
</div>

</body>
<!-- InstanceEnd --></html>