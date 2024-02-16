This documents a website I was asked to build with limited cooperation from infrustructure.
The following issues are known and I may correct them. 
1) Users with access to an agency and knowledge of the sql database for another agency could misrepresent themselves
   - I've considered adding a sessons variable to double check the agency they purport to represent
2) No user authentication
   - I did not have access to e-mail infrustructure.
   - I intended to add a randomly filled "code" field to users as well as an e-mail address
   - Trigger on insert and/or insert an e-mail for effected users presenting a new verification code
