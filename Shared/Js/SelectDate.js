function changeDate(val)
	{
		var d = new Date();
		var day1 = d.getFullYear();
		alert(d.getMonth());
	frm = document.searchForm;
	switch (val)
		{
		case '1':
			frm.Day1.value = d.getDate();
			frm.Month1.value = d.getMonth()+1;
			frm.Year1.value = d.getFullYear();
			frm.Day2.value = d.getDate();
			frm.Month2.value = d.getMonth()+1;
			frm.Year2.value = d.getFullYear();
			break;
		case '2':
			frm.Day1.value = d.getDate()-1;
			frm.Month1.value = d.getMonth()+1;
			frm.Year1.value = d.getFullYear();
			frm.Day2.value = d.getDate()-1;
			frm.Month2.value = d.getMonth()+1;
			frm.Year2.value = d.getFullYear();
			break;
		case '3':
			frm.Day1.value = d.getDate()-7;
			frm.Month1.value = d.getMonth()+1;
			frm.Year1.value = d.getFullYear();
			frm.Day2.value = d.getDate();
			frm.Month2.value = d.getMonth()+1;
			frm.Year2.value = d.getFullYear();
			break;
		case '4':
			
			frm.Day1.value = d.getUTCDay()+8;
			frm.Month1.value = d.getMonth()+1;
			frm.Year1.value = d.getFullYear();
			frm.Day2.value = d.getUTCDay()+8;
			frm.Month2.value = d.getMonth()+1;
			frm.Year2.value = d.getFullYear();
			break;
		case '5':
			
			frm.Day1.value = '10';
			frm.Month1.value = d.getMonth()+1;
			frm.Year1.value = d.getFullYear();
			frm.Day2.value = '14';
			frm.Month2.value = d.getMonth()+1;
			frm.Year2.value = d.getFullYear();
			break;
		case '6':
			frm.Day1.value = '1';
			frm.Month1.value =d.getMonth()+1;
			frm.Year1.value = d.getFullYear();
			frm.Day2.value = d.getDate();
			frm.Month2.value = d.getMonth()+1;
			frm.Year2.value = d.getFullYear();
			break;
		case '7':
			frm.Day1.value = '1';
			frm.Month1.value = d.getMonth();
			frm.Year1.value = d.getFullYear();
			frm.Day2.value = '29';
			frm.Month2.value = d.getMonth();
			frm.Year2.value = d.getFullYear();
			break;
		case '8':
			frm.Day1.selectedIndex = 0;
			frm.Month1.selectedIndex = 0;
			frm.Year1.selectedIndex = 0;
			frm.Day2.selectedIndex = 0;
			frm.Month2.selectedIndex = 0;
			frm.Year2.selectedIndex = 0;
			break;
		}
	}