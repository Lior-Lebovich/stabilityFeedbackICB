%% Behavioral - read participants p:
% in feedback data, the field 'oldResponse' denotes the actual respose
% (1=up/right and 0=down/left) whereas the field responseCongruent denotes
% whether the response is congruent(=1) or incungruent(=0) with the
% feedback manipulation.

% Note that the code below is as follows (using assign tables) to have the 
% behavioral read ordered as the ddm fit

dataNames = {'stability', 'feedback'};
taskNames = {'Vertical','Horizontal'};
dataTimeGroupNames.feedback = {'day','month'};
dataTimeGroupNames.stability = {'hour','day','week','month','months3',...
    'months8','years'};
timeStartName.stability = '';
timeStartName.feedback = 'time1';
relFields.stability = {'response'};
relFields.feedback = {'oldResponse','responseCongruent'};
nTrialsDevSessImp = 40;
nTrialsDevSessPos = 20;
devs.stability.Vertical = -10:2:10;
devs.feedback.Vertical = -10:2:10;
devs.stability.Horizontal = -10:2:10;
devs.feedback.Horizontal = -5:1:5;

for dat = 1:length(dataNames)
    dataName = dataNames{dat};
    timeNames = dataTimeGroupNames.(dataName);
    for ti = 1:length(timeNames)
        timeName = timeNames{ti};
        %read data:
        assignTable = readtable([dataName '/assignTables/assignTable_' ...
            dataName '_' timeStartName.(dataName) timeName '.csv']);
        uniIDs = assignTable.ID;
        nSubs = length(uniIDs);
        dataTable = readtable([dataName '/sortedTables/sortedTable_' ...
            dataName '_' timeStartName.(dataName) timeName '.csv']);
        nSessS = max(unique(dataTable.session));
        for task = 1:length(taskNames)
            taskName = taskNames{task};
            % if feedback, then also read the manipulations:
            if strcmp(dataName,'feedback')
                behav.(dataName).(taskName).(timeName).manip = ...
                    assignTable.(['manip' taskName(1:3)]);
            end
            %
            for dev = devs.(dataName).(taskName)
                if dev == 0
                    nTrialsDev = nTrialsDevSessImp;
                else
                    nTrialsDev = nTrialsDevSessPos;
                end
                if dev < 0
                    devName = ['m' num2str(abs(dev))];
                else 
                    devName = num2str(dev);
                end
                for sess = 1:nSessS
                    tableTaskDevSess = dataTable( strcmp( ...
                        dataTable.task,taskName) & ...
                        (dataTable.dev == dev) & ...
                        (dataTable.session == sess), : );
                    
                    % save RTs:
                    rtMat = nan(nSubs, nTrialsDev);
                    tempMissChs = nan(nSubs, nTrialsDev);
                    for sub = 1:length(uniIDs)
                        subID = uniIDs{sub};
                        rtMat(sub,:) = tableTaskDevSess( strcmp( ...
                            tableTaskDevSess.ID, subID ) , : ).rt';
                        tempMissChs(sub,:) = tableTaskDevSess( strcmp( ...
                            tableTaskDevSess.ID, subID ) , : ...
                            ).(relFields.(dataName){1})';
                    end
                    % omit missing decisions:
                    rtMat( tempMissChs == 999 ) = NaN;
                    
                    behav.(dataName).(taskName).(timeName).(['sess' ...
                        num2str(sess)]).(['dev' devName]...
                        ).rt.mat = rtMat;
                    behav.(dataName).(taskName).(timeName).(['sess' ...
                        num2str(sess)]).(['dev' devName]...
                        ).rt.mean = mean(rtMat,2,'omitnan');
                    
                    % save responses:
                    for f = 1:length(relFields.(dataName))
                        fieldName = relFields.(dataName){f};
                        relMat = nan(nSubs, nTrialsDev);
                        for sub = 1:length(uniIDs)
                            subID = uniIDs{sub};
                            relMat(sub,:) = tableTaskDevSess( strcmp( ...
                                tableTaskDevSess.ID, subID ) , : ).( ...
                                fieldName)';
                        end
                        relMat( isnan(rtMat) ) = NaN; % omit irrelevant/ missing RTs
                        relMat( relMat == 999 ) = NaN; % omit missing decisions
                        behav.(dataName).(taskName).(timeName).(['sess' ...
                            num2str(sess)]).(['dev' devName]...
                            ).(fieldName).mat = relMat;
                        behav.(dataName).(taskName).(timeName).(['sess' ...
                            num2str(sess)]).(['dev' devName]...
                            ).(fieldName).mean = mean(relMat,2,'omitnan');
                    end
                    
                end
            end
        end
    end
end

save('behavioralData.mat','behav');



%% Figure 4A,4B - feedback - pCon moving avg. AND psychometric curves:

load('behavioralData.mat');

taskNames = {'Vertical','Horizontal'};
dataTimeGroupNames.feedback = {'day','month'};
dataTimeGroupNames.stability = {'hour','day','week','month','months3',...
    'months8','years'};
devs.stability.Vertical = -10:2:10;
devs.feedback.Vertical = -10:2:10;
devs.stability.Horizontal = -10:2:10;
devs.feedback.Horizontal = -5:1:5;
toNormDev.Vertical = 100;
toNormDev.Horizontal = 75;
yLab.Vertical = 'p_{up}';
yLab.Horizontal = 'p_{right}';
xLab.Vertical = '\DeltaL/\SigmaL';
xLab.Horizontal = '\DeltaR/\SigmaR';
winSize = 10;

thisMans = [-1,1];
manipNames = {'decrease','increase'};
colMans = [0,0,1; 1,0,0];

firstDay = 1;
delDay31Table = readtable('feedback13_deltaTime1stLast.csv');
delDay32Table = readtable('feedback13_deltaTime2ndLast.csv');
mDelDay31_day = delDay31Table.mean( strcmp(delDay31Table.timeCondition, ...
    '1day') );
mDelDay32_day = delDay32Table.mean( strcmp(delDay32Table.timeCondition, ...
    '1day') );
mDelDay31_month = delDay31Table.mean( ...
    strcmp(delDay31Table.timeCondition, '1month') );
mDelDay32_month = delDay32Table.mean( ...
    strcmp(delDay32Table.timeCondition, '1month') );


dataName = 'feedback';
timeNames = dataTimeGroupNames.(dataName);
relField = 'oldResponse';

for task = 1:length(taskNames)
    taskName = taskNames{task};
    devVect = devs.(dataName).(taskName);

    figure;

    cell0Group1 = cell(length(timeNames)*length(manipNames),1);
    cellpGroup1 = cell(length(timeNames)*length(manipNames),11);
    for mm = 1:length(manipNames)
        cell0Group2.(manipNames{mm}) = cell(length(timeNames),1);
        cellpGroup2.(manipNames{mm}) = cell(length(timeNames),11);
        for tii = 1:length(timeNames)
            cell0Group3.(manipNames{mm}).(timeNames{tii}) = cell(1,1);
            cellpGroup3.(manipNames{mm}).(timeNames{tii}) = cell(1,11);
        end
    end

    % load relevant data:
    for ti = 1:length(timeNames)
        timeName = timeNames{ti}; 
        for m = 1:length(thisMans)
            thisMan = thisMans(m);
            manipName = manipNames{m};
            man =  behav.(dataName).(taskName).(timeName).manip;
            cell0Group1{m+length(thisMans)*(ti-1)} = ...
                behav.(dataName).(taskName).(timeName...
                ).sess1.dev0.(relField).mat( man == thisMan, : );
            cell0Group2.(manipName){ti,1} = ...
                behav.(dataName).(taskName).(timeName...
                ).sess2.dev0.(relField).mat( man == thisMan, : );
            cell0Group3.(timeName).(manipName){1,1} = ...
                behav.(dataName).(taskName).(timeName...
                ).sess3.dev0.(relField).mat( man == thisMan, : );

            for d = 1:length(devVect)
                thisDev = devVect(d);
                if thisDev >=0
                    devName = ['dev' num2str(thisDev)];
                else
                    devName = ['dev' 'm' num2str(abs(thisDev))];
                end
                cellpGroup1{m+length(thisMans)*(ti-1),d} = ...
                    behav.(dataName).(taskName).(timeName...
                    ).sess1.(devName).(relField).mean( man == thisMan );
                cellpGroup2.(manipName){ti,d} = ...
                    behav.(dataName).(taskName).(timeName...
                    ).sess2.(devName).(relField).mean( man == thisMan );
                cellpGroup3.(timeName).(manipName){1,d} = ...
                    behav.(dataName).(taskName).(timeName...
                    ).sess3.(devName).(relField).mean( man == thisMan );
            end
        end
    end

    % plot running window:

    % 1st session (all manips, all time groups):
    subplot(2,4,1);
    runningWindow( cell2mat(cell0Group1), winSize, 'on', [0,0,0] );
    xlabel('# trial'); ylabel(yLab.(taskName));
    title(['day ' num2str( round(firstDay) )]);
    for mmm = 1:length(manipNames)
        % 2nd session (separate manipulations, unite time conditions):
        subplot(2,4,2);
        runningWindow( cell2mat(cell0Group2.(manipNames{mmm})), ...
            winSize, 'on', colMans(mmm,:) ); hold on;
        for tiii = 1:length(timeNames)
            % 3rd session (separate manipulations and time conditions):
            subplot(2,4,2+tiii);
            runningWindow( cell2mat(cell0Group3.(timeNames{tiii}...
                ).(manipNames{mmm})), winSize, 'on', colMans(mmm,:) ); 
            hold on;
        end
    end
    subplot(2,4,2);
    title(['day ' num2str( round(firstDay+.5*( ...
        mDelDay31_day - mDelDay32_day + ...
        mDelDay31_month - mDelDay32_month)) )]);
    subplot(2,4,3);
    title(['day ' num2str( round(firstDay + mDelDay31_day) )]);
    subplot(2,4,4); 
    title(['day ' num2str( round(firstDay + mDelDay31_month) )]);

    % plot psychometric curve:
    
    % 1st session (all manips, all time groups):
    subplot(2,4,5);
    psychometric( cell2mat(cellpGroup1), devVect / toNormDev.(taskName), ...
        'on', [0,0,0] );
    ylabel(yLab.(taskName));
    for mmm = 1:length(manipNames)
        % 2nd session (separate manipulations, unite time conditions):
        subplot(2,4,6);
        psychometric( cell2mat(cellpGroup2.(manipNames{mmm})), ...
            devVect / toNormDev.(taskName), 'on', colMans(mmm,:) ); hold on;
        for tiii = 1:length(timeNames)
            % 3rd session (separate manipulations and time conditions):
            subplot(2,4,6+tiii);
            psychometric( cell2mat(cellpGroup3.(timeNames{tiii}...
                ).(manipNames{mmm})), devVect / toNormDev.(taskName), ...
                'on', colMans(mmm,:) ); hold on;
        end
    end
    
    for i = 1:4
        subplot(2,4,i);
        ylim([0,1]); yticks(0:.25:1); xlabel('# trial'); axis square;
        subplot(2,4,4+i);
        ylim([0,1]); yticks(0:.25:1); xlabel(xLab.(taskName)); axis square;
    end
    
end



%% Extended data Fig. 3B - feedback - p0 by group (manip. x delay) by sess:

load('behavioralData.mat');

taskNames = {'Vertical','Horizontal'};
dataTimeGroupNames.feedback = {'day','month'};
dataTimeGroupNames.stability = {'hour','day','week','month','months3',...
    'months8','years'};

toNormDev.Vertical = 100;
toNormDev.Horizontal = 75;
yLab.Vertical = 'p_{up}';
yLab.Horizontal = 'p_{right}';

thisMans = [-1,1];
manipNames = {'decrease','increase'};

cols.day.increase = [.64,.08,.18];
cols.month.increase = [1,.3,.3];
cols.day.decrease = [0,.45,.74];
cols.month.decrease = [.3,.75,.93];

firstDay = 1;
delDay31Table = readtable('feedback13_deltaTime1stLast.csv');
delDay32Table = readtable('feedback13_deltaTime2ndLast.csv');
mDelDay31_day = delDay31Table.mean( strcmp(delDay31Table.timeCondition, ...
    '1day') );
mDelDay32_day = delDay32Table.mean( strcmp(delDay32Table.timeCondition, ...
    '1day') );
mDelDay31_month = delDay31Table.mean( ...
    strcmp(delDay31Table.timeCondition, '1month') );
mDelDay32_month = delDay32Table.mean( ...
    strcmp(delDay32Table.timeCondition, '1month') );

nSessions = 3;

dataName = 'feedback';
timeNames = dataTimeGroupNames.(dataName);
relField = 'oldResponse';

for task = 1:length(taskNames)
    taskName = taskNames{task};
    figure;
    pMean = nan(1,4);
    pSem = nan(1,4);
    colMat = nan(4,3);
    for sess = 1:nSessions
        for ti = 1:length(timeNames)
            timeName = timeNames{ti};
            man = behav.(dataName).(taskName).(timeName).manip;
            for m = 1:length(thisMans)
                thisMan = thisMans(m);
                manipName = manipNames{m};
                pData = behav.(dataName).(taskName).(timeName).(['sess' ...
                    num2str(sess)]).dev0.(relField).mean( ...
                    man == thisMan, : );
                pMean(m+length(thisMans)*(ti-1)) = mean(pData,'omitnan');
                pSem(m+length(thisMans)*(ti-1)) = std(pData,'omitnan') ...
                    / sqrt( sum(~isnan(pData)) );
                colMat(m+length(thisMans)*(ti-1),:) = cols.(timeName).(...
                    manipName);
            end
        end
        if sess ~= 3
            subplot(1,4,sess);
            b = bar( 1:4, pMean );
            b.FaceColor = 'flat';
            b.EdgeColor = 'none';
            b.CData = colMat;
            hold on;
            errorbar( 1:4, pMean, pSem, 'Color', 'k', 'lineWidth', ...
                1, 'lineStyle', 'none' );
            if sess == 1
                ylabel(yLab.(taskName));
            end
        elseif sess == 3
            for tii = 1:2
                subplot(1,4,sess+tii-1);
                locs = (1:2)+2*(tii-1);
                b = bar( locs, pMean(locs) );
                b.FaceColor = 'flat';
                b.EdgeColor = 'none';
                b.CData = colMat(locs,:);
                hold on;
                errorbar( locs, pMean(locs), pSem(locs), 'Color', ...
                    'k', 'lineWidth', 1, 'lineStyle', 'none' ); 
            end
        end
    end
    subplot(1,4,1); 
    title(['day ' num2str( round(firstDay) )]);
    subplot(1,4,2);
    title(['day ' num2str( round(firstDay+.5*( ...
        mDelDay31_day - mDelDay32_day + ...
        mDelDay31_month - mDelDay32_month)) )]);
    subplot(1,4,3);
    title(['day ' num2str( round(firstDay + mDelDay31_day) )]);
    subplot(1,4,4); 
    title(['day ' num2str( round(firstDay + mDelDay31_month) )]);
    for tiii = 1:4
        subplot(1,4,tiii); ylim([0,1]); xlim([.5,4.5]); xticks({});
        yticks(0:.25:1);
    end
end



%% TESTS - feedback:

load('behavioralData.mat');


% Wilcoxon rank sum test for the difference in p0 medians in 2nd session:
pDay_manUp = behav.feedback.Vertical.day.sess2.dev0.oldResponse.mean( ...
    behav.feedback.Vertical.day.manip == 1 );
pDay_manDown = behav.feedback.Vertical.day.sess2.dev0.oldResponse.mean( ...
    behav.feedback.Vertical.day.manip == -1 );
pMonth_manUp = behav.feedback.Vertical.month.sess2.dev0.oldResponse.mean( ...
    behav.feedback.Vertical.month.manip == 1 );
pMonth_manDown = behav.feedback.Vertical.month.sess2.dev0.oldResponse.mean( ...
    behav.feedback.Vertical.month.manip == -1 );
pManUp = [pDay_manUp; pMonth_manUp];
pManDown = [pDay_manDown; pMonth_manDown];
[p,h,stats] = ranksum(pManUp,pManDown);
pValue__ranksumtest_upVsDown_p0sess2 = p
stats__ranksumtest_upVsDown_p0sess2 = stats


% Wilcoxon rank sum test for the difference in p0 medians in 3rd session by
    % delay-group:
pDay_manUp = ...
    behav.feedback.Vertical.day.sess3.dev0.oldResponse.mean( ...
    behav.feedback.Vertical.day.manip == 1 );
pDay_manDown = ...
    behav.feedback.Vertical.day.sess3.dev0.oldResponse.mean( ...
    behav.feedback.Vertical.day.manip == -1 );
pMonth_manUp = ...
    behav.feedback.Vertical.month.sess3.dev0.oldResponse.mean( ...
    behav.feedback.Vertical.month.manip == 1 );
pMonth_manDown = ...
    behav.feedback.Vertical.month.sess3.dev0.oldResponse.mean( ...
    behav.feedback.Vertical.month.manip == -1 );
% compare effects in the third session - 1 day:
[p,~,stats] = ranksum(pDay_manUp,pDay_manDown)
pValue__ranksumtest_upVsDown_p0sess3_day = p
stats__ranksumtest_upVsDown_p0sess3_day = stats
% compare effects in the third session - 1 month:
[p,~,stats] = ranksum(pMonth_manUp,pMonth_manDown);
pValue__ranksumtest_upVsDown_p0sess3_month = p
stats__ranksumtest_upVsDown_p0sess3_month = stats

% Wilcoxon rank sum test for the difference in p0 medians in 2nd session
    % for moving avg. (Fig. 4A)

% compare effects in the second session - by running window part:
pVal = nan(31,1);
for r = 1:31
    pDay_manUp = mean( ...
        behav.feedback.Vertical.day.sess2.dev0.oldResponse.mat( ...
        behav.feedback.Vertical.day.manip == 1, r:r+10-1 ), 2 );
    pDay_manDown = mean( ...
        behav.feedback.Vertical.day.sess2.dev0.oldResponse.mat( ...
        behav.feedback.Vertical.day.manip == -1, r:r+10-1 ), 2 );
    pMonth_manUp = mean( ...
        behav.feedback.Vertical.month.sess2.dev0.oldResponse.mat( ...
        behav.feedback.Vertical.month.manip == 1, r:r+10-1 ), 2 );
    pMonth_manDown = mean( ...
        behav.feedback.Vertical.month.sess2.dev0.oldResponse.mat( ...
        behav.feedback.Vertical.month.manip == -1, r:r+10-1 ), 2 );
    pManUp = [pDay_manUp; pMonth_manUp];
    pManDown = [pDay_manDown; pMonth_manDown];
    pVal(r) = ranksum(pManUp,pManDown,'tail','right');
end
figure;
iComp = (1:31)';
plot( iComp, pVal, 'k', 'lineWidth', 1 ); hold on;
sigComps = plot( iComp(pVal<.05), pVal(pVal<.05), 'r*' ); 
hold on;
xlabel('k');
ylabel('pValue for trials k:k+10-1');
title('Rank sum test for p_{Up}^0 in sess2 up vs down manip. -by trials')
legend(sigComps,'pVal<.05, not corrected for mult. comp.')


% Simulate the difference in corr(pCon0_sess1,pCon0_sess3) between the two
    % delay groups by bootstrapping participants' identities (and corresp. 
    % pCon's) either:
    % (a) Separately from each delay group.
    % (b) Irrespective of the delay group.
% compare corr(pCongruent_1,pCongruent_3) = in the 1day and 1month groups.
pCon3day = behav.feedback.Vertical.day.sess3.dev0.responseCongruent.mean;
pCon1day = behav.feedback.Vertical.day.sess1.dev0.responseCongruent.mean;
pCon3month = ...
    behav.feedback.Vertical.month.sess3.dev0.responseCongruent.mean;
pCon1month = ...
    behav.feedback.Vertical.month.sess1.dev0.responseCongruent.mean;
realCorrDiff = corr(pCon3month,pCon1month) - corr(pCon3day,pCon1day);
pCon1both = [pCon1day; pCon1month];
pCon3both = [pCon3day; pCon3month];
nSims = 1e6; 
simCorrDay = nan(nSims,1);
simCorrMonth = nan(nSims,1);
simCorrDay_rand = nan(nSims,1);
simCorrMonth_rand = nan(nSims,1);
simCorrDay_rand_noRet = nan(nSims,1);
simCorrMonth_rand_noRet = nan(nSims,1);
nDay = length(pCon3day);
nMonth = length(pCon3month);
sss = RandStream('mlfg6331_64'); 
for s = 1:nSims
    s
    % (a) Bootstrap participants corresp. pCon0's separately for each delay 
        % group:
    sLocDay = datasample( sss, 1:nDay, nDay );
    sLocMonth = datasample( sss, 1:nMonth, nMonth );
    simCorrDay(s) = corr( pCon1day(sLocDay), pCon3day(sLocDay) );
    simCorrMonth(s) = corr( pCon1month(sLocDay), pCon3month(sLocDay) );
    % (b1) Bootstrap participants corresp. pCon0's irrespective of delay 
        % group [WITH replacement]:
    sLocBoth = datasample( sss, 1:(nDay+nMonth), nDay+nMonth );
    simCorrDay_rand(s) = corr( pCon1both(sLocBoth(1:nDay)), ...
        pCon3both(sLocBoth(1:nDay)) );
    simCorrMonth_rand(s) = corr( pCon1both(sLocBoth(nDay+1:end)), ...
        pCon3both(sLocBoth(nDay+1:end)) );
    % (b2) Bootstrap participants corresp. pCon0's irrespective of delay 
        % group [WITHOUT replacement]:
    sLocBothNR = datasample( sss, 1:(nDay+nMonth), nDay+nMonth, ...
        'Replace', false );
    simCorrDay_rand_noRet(s) = corr( pCon1both(sLocBothNR(1:nDay)), ...
        pCon3both(sLocBothNR(1:nDay)) );
    simCorrMonth_rand_noRet(s) = corr( ...
        pCon1both(sLocBothNR(nDay+1:end)), ...
        pCon3both(sLocBothNR(nDay+1:end)) );
end
% (a) pValue for the difference in corr(pCon0_sess1,pCon0_sess3) between 
    % delay groups [sampled WITH replacement, from each delay group]:
pValue__bootstrap_deltaCorr_pCon0Sess1vs3_sampleFromDelayGroups = ...
    mean( simCorrDay > simCorrMonth ) 
% (b1) pValue for the difference in corr(pCon0_sess1,pCon0_sess3) between 
    % delay groups [sampled WITH replacement, irrespective of delay group]:
simCorrDiff = simCorrMonth_rand - simCorrDay_rand;
pValue__bootstrap_deltaCorr_pCon0Sess1vs3_sampleAllParticipants_replaceTrue = ...
    mean( simCorrDiff >= realCorrDiff )
% (b2) pValue for the difference in corr(pCon0_sess1,pCon0_sess3) between 
    % delay groups [sampled WITHOUT replacement, irrespective of delay 
    % group]:
simCorrDiff = simCorrMonth_rand_noRet - simCorrDay_rand_noRet;
pValue__bootstrap_deltaCorr_pCon0Sess1vs3_sampleAllParticipants_replaceFalse = ...
    mean( simCorrDiff >= realCorrDiff )



%% Figure 2C, Figure 6B: between-sessions bias correlation and 95% CI's:

load('behavioralData.mat');

dataNames = {'stability', 'feedback'};
taskNames = {'Vertical','Horizontal'};
dataTimeGroupNames.feedback = {'day','month'};
dataTimeGroupNames.stability = {'hour','day','week','month','months3',...
    'months8','years'};
dataTimeGroupNames2.feedback = dataTimeGroupNames.feedback;
dataTimeGroupNames2.stability = {'hour','day','week','month','3 months',...
    '8 months','22 months'};
timeStartName.stability = '';
timeStartName.feedback = 'time1';
choiceFields.stability = 'response';
choiceFields.feedback = 'oldResponse';
nTrialsDevSessImp = 40;
nLastSess.feedback = 3;
nLastSess.stability = 2;
nComps.feedback = 3;
nComps.stability = 1;
nSims = 1e5;

for dat = 1:length(dataNames)
    dataName = dataNames{dat};
    % read mean days between sessions:
    if strcmp(dataName,'feedback')
        deltaTimeTable = readtable('feedback13_deltaTime2ndLast.csv');
        addTimeName = '1';
    else
        deltaTimeTable = readtable('stability_deltaTime1stLast.csv');
        addTimeName = '';
    end
    timeNames = dataTimeGroupNames.(dataName);
    dayMean.(dataName) = nan(1,length(timeNames));
    for ti = 1:length(timeNames)
        timeName = timeNames{ti};
        dayMean.(dataName)(ti) = deltaTimeTable( strcmp( ...
            deltaTimeTable.timeCondition, [addTimeName timeName]), : ).mean;
    end
end

for dat = 1:length(dataNames)
    dataName = dataNames{dat};
    nComp = nComps.(dataName);
    timeNames = dataTimeGroupNames.(dataName);
    timeNames2 = dataTimeGroupNames2.(dataName);
    figNoLog = figure;
    figLog = figure;
    figBars = figure;
    for task = 1:length(taskNames)
        taskName = taskNames{task};
        nSessions = nLastSess.(dataName);
        for oth = 1:(nSessions-1)
            for oth2 = oth+1:nSessions
                figure(figNoLog);
                subplot(2,nComp, oth+oth2 - 2 + (nComp)*(task-1));
                figure(figLog);
                sb = subplot(2,nComp, oth+oth2 - 2 + (nComp)*(task-1));
                sb.XScale='log';
                figure(figBars);
                subplot(2,nComp, oth+oth2 - 2 + (nComp)*(task-1));
                corrTask = nan(1,length(timeNames));
                sigTask = nan(1,length(timeNames));
                corrTask_95sim_sub = nan(2,length(timeNames));
                corrTask_95sim_noStab = nan(2,length(timeNames));
                corrTask_95sim_compStab = nan(2,length(timeNames));
                pVal_corrTask_sim_compStab = nan(1,length(timeNames));
                for ti = 1:length(timeNames)
                    timeName = timeNames{ti};
                    fieldName = choiceFields.(dataName);
                    p1 = behav.(dataName).(taskName).(timeName).(...
                        ['sess' num2str(oth)]).dev0.(fieldName).mean;
                    pOther = behav.(dataName).(taskName).(timeName).(...
                        ['sess' num2str(oth2)]).dev0.(fieldName).mean;
                    [rho,pVal] = corr(p1,pOther);
                    corrTask(ti) = rho;
                    sigTask(ti) = pVal;
                    simCorr = nan(nSims,1);
                    simCorr_noStab = nan(nSims,1);
                    simCorr_compStab = nan(nSims,1);
                    for s = 1:nSims
                        locSim = datasample( 1:length(p1), length(p1) );
                        locSim2 = datasample( 1:length(p1), length(p1) );
                        % bootstrap corr by subjects:
                        p1Sim = p1(locSim);
                        pOtherSim = pOther(locSim);
                        simCorr(s) = corr(p1Sim,pOtherSim);
                        % bootstrap corr by subjects assuming no stability:
                        p1Sim = p1(locSim);
                        pOtherSim = pOther(locSim2);
                        simCorr_noStab(s) = corr(p1Sim,pOtherSim);
                        % assuming complete stability:
                        % Here, we boostap and also binomrnd the mean p's, to
                        % simulate the corr expected under the assumption that 
                        % the inherent p hadn't changed. Note that this will
                        % only serve as a lower bound for complete stability,
                        % and that this simulation is biased, e.g.,
                        % beacause it has the potential to decrease the 
                        % variance between participants. 
                        pMeanBoot = .5 * (p1(locSim) + pOther(locSim) );
                        p1Sim = (1/nTrialsDevSessImp) * binornd( ...
                            nTrialsDevSessImp, pMeanBoot );
                        pOtherSim = (1/nTrialsDevSessImp) * binornd( ...
                            nTrialsDevSessImp, pMeanBoot );
                        simCorr_compStab(s) = corr(p1Sim,pOtherSim);
                    end
                    corrTask_95sim_sub(:,ti) = quantile( simCorr, [.025;.975] );
                    corrTask_95sim_noStab(:,ti) = quantile( simCorr_noStab, ...
                        [.025;.975] );
                    corrTask_95sim_compStab(:,ti) = quantile( ...
                        simCorr_compStab, [.025;.975] );
                    pVal_corrTask_sim_compStab(ti) = mean( ...
                        simCorr_compStab < corrTask(ti) );
                end
                % plot correlation and bootstrap-based 95% CI - no log:
                figure(figNoLog);
                patch( [1:length(timeNames), flip(1:length(timeNames))], ...
                    [corrTask_95sim_noStab(1,:), ...
                    flip(corrTask_95sim_noStab(2,:))], ...
                    'r', 'EdgeColor', 'none', 'FaceAlpha', .3 ); hold on;
                patch( [1:length(timeNames), flip(1:length(timeNames))], ...
                    [corrTask_95sim_compStab(1,:), ...
                    flip(corrTask_95sim_compStab(2,:))], ...
                    'k', 'EdgeColor', 'none', 'FaceAlpha', .3 ); hold on;
                patch( [1:length(timeNames), flip(1:length(timeNames))], ...
                    [corrTask_95sim_sub(1,:), ...
                    flip(corrTask_95sim_sub(2,:))], ...
                    'b', 'EdgeColor', 'none', 'FaceAlpha', .3 ); hold on;
                plot( 1:length(timeNames), corrTask, 'b', 'marker', '.', ...
                    'lineWidth', 1 ); hold on;
                tv = 1:length(timeNames);
                plot( tv(sigTask<=0.05), -.8*ones(1,sum(sigTask<=0.05)), ...
                    'b+', tv(sigTask<=0.001), ...
                    -.8*ones(1,sum(sigTask<=0.001)), 'bx' ); hold on;
                
                ylim([-1,1]); yticks(-1:.2:1); ylabel('Corr. (\rho)');
                xticks(1:length(timeNames));
                xticklabels( timeNames2 ); xtickangle(45);
                grid on;
                xlabel(['sess.' num2str(oth) ' vs. ' num2str(oth2)]);
                title([dataName '-' taskName]);
                
                % plot correlation and bootstrap-based 95% CI - log scale:
                figure(figLog);
                %{
                patch( [dayMean.(dataName), flip(dayMean.(dataName))], ...
                    [corrTask_95sim_noStab(1,:), ...
                    flip(corrTask_95sim_noStab(2,:))], ...
                    'r', 'EdgeColor', 'none', 'FaceAlpha', .3 ); hold on;
                %}
                %{
                bar( dayMean.(dataName), corrTask, 'k', 'edgeColor', ...
                    'none', 'faceAlpha', .3 ); hold on;
                errorbar( dayMean.(dataName), corrTask, ...
                    corrTask_95sim_sub(1,:)-corrTask, ...
                    corrTask_95sim_sub(2,:)-corrTask, ...
                    'k', 'lineStyle', 'none', 'lineWidth', 1 ); hold on;
                patch( [dayMean.(dataName), flip(dayMean.(dataName))], ...
                    [corrTask_95sim_compStab(1,:), ...
                    flip(corrTask_95sim_compStab(2,:))], ...
                    'm', 'EdgeColor', 'none', 'FaceAlpha', .3 ); hold on;
                %}
                %
                patch( [dayMean.(dataName), flip(dayMean.(dataName))], ...
                    [corrTask_95sim_compStab(1,:), ...
                    flip(corrTask_95sim_compStab(2,:))], ...
                    'k', 'EdgeColor', 'none', 'FaceAlpha', .3 ); hold on;
                patch( [dayMean.(dataName), flip(dayMean.(dataName))], ...
                    [corrTask_95sim_sub(1,:), ...
                    flip(corrTask_95sim_sub(2,:))], ...
                    'b', 'EdgeColor', 'none', 'FaceAlpha', .3 ); hold on;
                plot( dayMean.(dataName), corrTask, 'b', 'marker', '.', ...
                    'lineWidth', 1 ); hold on;
                %}
                ylim([-1,1]); yticks(-1:.2:1); ylabel('Corr. (\rho)');
                xticks(dayMean.(dataName));
                xticklabels( timeNames2 ); xtickangle(45);
                grid on;
                xlabel(['sess.' num2str(oth) ' vs. ' num2str(oth2)]);
                title([dataName '-' taskName]);
                set(gca,'XScale','log')
                % we add the below for presentation purposes:
                %{
                for tii = 1:length(timeNames)
                    plot( dayMean.(dataName)(tii)*[1;1], ...
                        corrTask_95sim_sub(:,tii), 'b-', 'Marker', ...
                        '.', 'lineWidth', 1 ); hold on;
                end
                %}

                figure(figBars);
                b = bar( 1:length(timeNames), corrTask, 'faceColor', [.5,.5,.5], ...
                    'edgeColor', 'none');
                hold on;
                errorbar( 1:length(timeNames), corrTask, ...
                    corrTask - corrTask_95sim_sub(1,:), ...
                    -corrTask + corrTask_95sim_sub(2,:), 'lineStyle', 'none', ...
                    'Color', 'k', 'lineWidth', 1 ); hold on;
                barWidth = b.BarWidth;
                for ttt = 1:length(timeNames)
                    patch( [ttt-.5*barWidth, ttt-.5*barWidth, ...
                        ttt+.5*barWidth, ttt+.5*barWidth], ...
                        [corrTask_95sim_compStab(1,ttt), ...
                        corrTask_95sim_compStab(2,ttt), ...
                        corrTask_95sim_compStab(2,ttt), ...
                        corrTask_95sim_compStab(1,ttt)], ...
                        'm', 'EdgeColor', 'none', 'FaceAlpha', .3 ); hold on;
                    plot( ttt, corrTask(ttt), 'marker', 'o', ...
                        'MarkerFaceColor', 'k', 'MarkerEdgeColor', 'none' );
                    hold on;
                end
                xticks( 1:length(timeNames) ); xticklabels( timeNames2 );
                % xtickangle(45);
                ylim([0,1]); yticks(0:.25:1); ylabel('Corr. (\rho)');
                grid on;
                xlabel(['sess.' num2str(oth) ' vs. ' num2str(oth2)]);
                title([dataName '-' taskName]);
            end
        end
    end
end



%% Fig. 5B - feedback - mean delta p = p3-p2:

load('behavioralData.mat');

taskNames = {'Vertical','Horizontal'};
dataTimeGroupNames.feedback = {'day','month'};
timeNames = dataTimeGroupNames.feedback;

for task = 1:2
    %subplot( length(taskNames), 1, task );
    taskName = taskNames{task};
    mDelta = nan( length(timeNames), 1 );
    semDelta = nan( length(timeNames), 1 );
    figAll = figure;
    figDelta = figure;
    for ti = 1:length(timeNames)
        timeName = timeNames{ti};
        figure(figAll);
        pSess3 = behav.feedback.(taskName).(timeName...
            ).sess3.dev0.responseCongruent.mean;
        pSess2LastHalf = mean( ...
            behav.feedback.(taskName).(timeName...
            ).sess2.dev0.responseCongruent.mat(:,21:40), 2 );
        bar( ti+[0,2], mean([pSess2LastHalf,pSess3]), 'faceColor', ...
            [.5,.5,.5], 'edgeColor', 'k', 'barWidth', .4 ); hold on;
        errorbar( ti+[0,2], mean([pSess2LastHalf,pSess3]), ...
            std([pSess2LastHalf,pSess3]) ./ ...
            sqrt([length(pSess2LastHalf),length(pSess3)]), ...
            'k', 'lineWidth', 1, 'lineStyle', 'none' ); hold on;
        figure(figDelta);
        delta = pSess3 - pSess2LastHalf;
        mDelta = mean(delta);
        semDelta = std(delta) / sqrt( length(delta) );
        bar( ti, mDelta, 'faceColor', [.5,.5,.5], 'edgeColor', 'k', ...
            'barWidth', .8 ); hold on;
        errorbar( ti, mDelta, semDelta, 'k', 'lineWidth', 1, ...
            'lineStyle', 'none' );
    end 
    figure(figAll);
    xticks(1:4); xticklabels({'2','2','3','31'}); title(taskName);
    ylabel('{\itp}^0_{{\itcon}}'); xlim([.5,4.5]);
    figure(figDelta);
    xticks(1:2); xticklabels(timeNames); title(taskName);
    ylabel('\Delta{\itp}^0_{{\itcon}}'); xlim([.5,2.5])
end



%% Fig. 1A-B, Fig. 2B, Fig. 5A, Fig. 6A, Extended data Figs. 1, 2, 3A  AND TESTS:


load('behavioralData.mat');
dataNames = {'stability','feedback'};
taskNames = {'Vertical','Horizontal'};
dataTimeGroupNames.feedback = {'day','month'};
dataTimeGroupNames.stability = {'hour','day','week','month','months3',...
    'months8','years'};
dataTimeGroupNames2.stability = {'hour','day','week','month','3 months',...
    '8 months','22 months'};
devs.stability.Vertical = -10:2:10;
devs.feedback.Vertical = -10:2:10;
devs.stability.Horizontal = -10:2:10;
devs.feedback.Horizontal = -5:1:5;
toNormDev.Vertical = 100;
toNormDev.Horizontal = 75;
nTrialsVect = [20*ones(1,5), 40, 20*ones(1,5)];
xLab.Vertical = '\DeltaL/L';
xLab.Horizontal = '\DeltaR/R';
yLab.Vertical = 'p_{up}';
yLab.Horizontal = 'p_{right}';


% STABILITY DATA:
dat = 1;
dataName = dataNames{dat};
timeNames = dataTimeGroupNames.(dataName);
timeNames2 = dataTimeGroupNames2.(dataName);
for task = 1:length(taskNames)
    taskName = taskNames{task};
    lastPar = 0;
    pMat.(taskName) = nan(183,11);
    timeCell = cell(183,1);
    for ti = 1:length(timeNames)-1
        timeName = timeNames{ti};
        timeName2 = timeNames2{ti};
        nSubsTime = length( behav.(dataName).Vertical.(timeName).sess1.dev0.response.mean );
        timeCell(lastPar+1:lastPar+nSubsTime) = {timeName2};
        DEV = devs.(dataName).(taskName);
        for d = 1:length(DEV)
            dev = DEV(d);
            if dev < 0
                devName = ['m' num2str(abs(dev))];
            else
                devName = num2str(dev);
            end
            pMat.(taskName)( lastPar+1:lastPar+nSubsTime, d ) = ...
                behav.(dataName).(taskName).(timeName).sess1.(...
                ['dev' devName]).response.mean;
        end
        lastPar = lastPar + nSubsTime;
    end
end


% Compute performance:
performanceVertical = 0.5 * ( 1 - mean( pMat.Vertical(:,1:5), 2 ) + ...
    mean( pMat.Vertical(:,7:11), 2 ) );
performanceVertical_avg = mean(100 * performanceVertical)
performanceVertical_std = std(100 * performanceVertical) 
performanceVertical_minmax = 100 * [min(performanceVertical), ...
    max(performanceVertical)]
%
performanceHorizontal = 0.5 * ( 1 - mean( pMat.Horizontal(:,1:5), 2 ) + ...
    mean( pMat.Horizontal(:,7:11), 2 ) );
performanceHorizontal_avg = mean(100 * performanceHorizontal)
performanceHorizontal_std = std(100 * performanceHorizontal) 
performanceHorizontal_minmax = 100 * [min(performanceHorizontal), ...
    max(performanceHorizontal)]


% Fig. 1A - stability - 3 eaxmple psychometric curves:
subPsycho.Vertical = [130,116,83]; 
subPsycho.Horizontal = [69,11,167]; 
ft = fittype( '(1+exp(-a*(x-b)))^(-1)', 'independent', 'x', 'dependent', ...
    'y' );
opts = fitoptions( 'Method', 'NonlinearLeastSquares' );
opts.Display = 'Off';
opts.StartPoint = [0.7791 0.8427];
cols = {'blue', 'black', 'red'};
marks = {'o', 's', 'd'};
for task = 1:length(taskNames)
    taskName = taskNames{task};
    devVect = devs.(dataName).(taskName) / toNormDev.(taskName);
    figure;
    for k = 1:3
        col = cols{k};
        mark = marks{k};
        pSub = pMat.(taskName)(subPsycho.(taskName)(k),:);
        [xDataSS, yDataSS1] = prepareCurveData(devVect,pSub);
        [fitresult, ~] = fit( xDataSS, yDataSS1, ft, opts );
        errorbar( devVect, pSub, sqrt( pSub .* (1-pSub) ./ nTrialsVect ...
            ), 'MarkerEdgeColor', 'none', 'MarkerSize', 5, 'Marker', ...
            mark, 'LineStyle', 'none', 'lineWidth', 1, 'color', col, ...
            'MarkerFaceColor', col ); 
        hold on; 
        plot(fitresult,col); hold on;
    end
    xlim([min(devVect),max(devVect)]); ylim([0,1]); box off; legend off;
    xlabel(xLab.(taskName)); ylabel(yLab.(taskName));
    ggg = gca; 
    ggg.XMinorTick = 'on'; 
    ggg.YMinorTick = 'on';
    xticks(-0.1:0.1:0.1); yticks(0:0.5:1);
end


% Fig. 1B - stability - ICB distribution:
for task = 1:length(taskNames)
    taskName = taskNames{task};
    edges = linspace(0,1,42);
    ICB_BL_pdf = histcounts( pMat.(taskName)(:,6), 'binEdges', edges );
    figure;
    bar( 0:(1/40):1, ICB_BL_pdf, 'FaceColor', [.5 .5 .5], 'edgeColor', ...
        'none' ); 
    xlim([-0.025,1.025]); 
    box off; 
    xlabel('ICB'); 
    ylabel('# participants');
    ggg = gca; ggg.XMinorTick = 'on'; ggg.YMinorTick = 'on';
    xticks(0:.25:1); hold on;
    % plot ICBs that correspond to the 3 psychometric curves: 
    for k = 1:3
        col = cols{k};
        ICB_subPsy = pMat.(taskName)(subPsycho.(taskName)(k),6);
        relatedPDF = ICB_BL_pdf( find( 0:40 == round(40*ICB_subPsy) ) );
        text( ICB_subPsy, relatedPDF, '\downarrow', 'color', col, ...
            'FontSize',15, 'HorizontalAlignment', 'center', ...
            'VerticalAlignment', 'bottom', 'FontWeight', 'bold');
        hold on;
    end
end


% Extended data Fig. 1 - ICB impossible vs. possible:
for task = 1:length(taskNames)
    taskName = taskNames{task};
    figure;
    pPos = mean( pMat.(taskName)(:,[1:5,7:end]), 2 );
    pImp = pMat.(taskName)(:,6);
    bias_imp_pos_unique = unique( [pImp, pPos], 'rows' );
    all_mSize_check = nan(1, length(bias_imp_pos_unique) );
    for i = 1:length(bias_imp_pos_unique)
        mSize = sum( ( pImp == bias_imp_pos_unique(i,1) ) .* ...
            ( pPos == bias_imp_pos_unique(i,2) ) );
        all_mSize_check(i) = mSize;
        plotDots = plot( bias_imp_pos_unique(i,1), ...
            bias_imp_pos_unique(i,2), ...
            'Marker', 'o', 'MarkerSize', 4+2*(mSize-1), ...
            'MarkerFaceColor', [0,0,0], 'Color', [1 1 1] ); hold on; 
    end
    % describe dot size:
    nPairs = length(all_mSize_check)
    nPairs_singleParticipants = sum(all_mSize_check==1)
    nPairs_participantsSharingPairs = sum(all_mSize_check>1)
    nParticipantsSharingPair = sum( all_mSize_check(all_mSize_check>1) )
    unique_nParticipantsSharingPairs = unique(all_mSize_check);
    % Orthogonal regression:
    v = pca([pImp pPos]);
    slope = v(2,1)/v(1,1);
    k = mean( pPos ) - slope * mean( pImp );
    plot( [0,1], slope * [0,1] + k, 'Color', [1,1,1], 'lineWidth', 2 ); 
    hold on;
    h = plot( [0,1], slope * [0,1] + k, 'Color', [0,0,0], 'lineWidth', 1 ); 
    hold on;
    mean_imp = mean( pImp );
    mean_pos = mean( pPos );
    sem_imp = std( pImp ) / sqrt( length(pImp) );
    sem_pos = std( pPos ) / sqrt( length(pPos) );
    [rho, pVal] = corr( pImp, pPos );
    legend( [plotDots,h], ['data: rho = ' num2str(rho) ...
        ', p = ' num2str(pVal)], ...
        ['Ortho. reg: ICB_{pos} = ' num2str(slope) ' * ICB_{imp}'], ...
        'Location','SouthOutside');
    xlabel('ICB impossible');
    ylabel('ICB possible')
    box off; axis square; 
    ggg = gca; ggg.XMinorTick = 'on'; ggg.YMinorTick = 'on';    
end


% Fig. 2B - stability - ICB 1st session vs. 2nd session - 8 months:
timeName = 'months8';
for task = 1:length(taskNames)
    taskName = taskNames{task};
    figure;
    p1 = behav.(dataName).(taskName).(timeName).sess1.dev0.response.mean;
    p2 = behav.(dataName).(taskName).(timeName).sess2.dev0.response.mean;
    plotDots = plot(p1, p2, 'Marker','o','MarkerSize',5, ...
        'MarkerFaceColor', [0,0,0],'Color',[1 1 1]); hold on;
    % Orthogonal regression:
    v = pca([p1 p2]);
    slope = v(2,1)/v(1,1);
    k = mean( p2 ) - slope * mean( p1 );
    plot( [0,1], slope * [0,1] + k, 'Color', [1,1,1], 'lineWidth', 2 ); 
    hold on;
    h = plot( [0,1], slope * [0,1] + k, 'Color', [0,0,0], 'lineWidth', 1 ); 
    hold on;
    mean_imp = mean( p1 );
    mean_pos = mean( p2 );
    sem_imp = std( p1 ) / sqrt( length(p1) );
    sem_pos = std( p2 ) / sqrt( length(p2) );
    [rho, pVal] = corr( p1, p2 );
    legend( [plotDots,h], ['data: rho = ' num2str(rho) ', p = ' ...
        num2str(pVal)], ['Ortho. reg: ICB_{pos} = ' num2str(slope) ...
        ' * ICB_{imp}'], 'Location','SouthOutside');
    xlabel('p_{up}^0 session 1');
    ylabel('p_{up}^0 session 2')
    box off; axis square; xlim([0,1]); ylim([0,1]);
    ggg = gca; ggg.XMinorTick = 'on'; ggg.YMinorTick = 'on'; 
end


% Extended data Fig. 2: ICB 1st vs. 2nd sess (as in Fig. 2B), for all other 
    % conditions:
timeNames = dataTimeGroupNames.stability( ...
    ~strcmp( dataTimeGroupNames.stability, 'months8' ) );
timeNames2 = dataTimeGroupNames2.stability( ...
    ~strcmp( dataTimeGroupNames.stability, 'months8' ) );
for task = 1:length(taskNames)
    taskName = taskNames{task};
    figure;
    for ti = 1:length(timeNames)
        timeName = timeNames{ti};
        timeName2 = timeNames2{ti};
        subplot(2,3,ti);
        if strcmp(timeName,'years')
            sessA = '2';
            sessB = '3';
        else
            sessA = '1';
            sessB = '2';
        end
        pA = behav.stability.(taskName).(timeName).sess1.dev0.response.mean;
        pB = behav.stability.(taskName).(timeName).sess2.dev0.response.mean;
        plot(pA, pB, 'Marker','o','MarkerSize',5, ...
            'MarkerFaceColor', [0,0,0],'Color',[1 1 1]); hold on;
        xlabel(['p^0 session ' sessA]);
        ylabel(['p^0 session ' sessB])
        title(timeName2);
        box off; axis square; xlim([0,1]); ylim([0,1]);
        ggg = gca; ggg.XMinorTick = 'on'; ggg.YMinorTick = 'on';
    end
end


% Fig. 1 tests:

ICB1 = pMat.Vertical(:,6);

% Significant biases: Binomial tests, not corrected for multiple
% comparispons.
% Compute #significant, 2-sided binomial test:
sigBiasesLoc = (myBinomTest( 40*ICB1, 40, .5 ) < .05);
sumSigBias = sum( sigBiasesLoc );
percentSigBias = mean( sigBiasesLoc )
percentSigUpBias = mean( sigBiasesLoc & (ICB1 > .5) )
percentSigDownBias = mean( sigBiasesLoc & (ICB1 < .5) )
% significant biases correspond to pUp<=0.325(13/40) or pUp>=0.675(27/40):
pdfBinom =  pdf('Binomial',0:40,40,0.5);
maximalSigAlpha = sum(pdfBinom(1:14))*2;

% Compute significance levels for the 3 participants in Fig. 1a:
pUp_sig_mat = nan(3,2);
for k =1:3
    pUp_sig_mat(k,1) = pMat.Vertical( subPsycho.Vertical(k), 6 );
    pUp_sig_mat(k,2) = myBinomTest( 40 * pUp_sig_mat(k,1), 40, 1/2 );
end
pUp_sig_mat

% MAD ICB:
mad_ICB = mad( ICB1 )
% mean+-SEM ICB in possible trials:
ICB1pos = mean( pMat.Vertical(:,[1:5,7:end]), 2 );
mad( ICB1pos )
% correlation of ICB in im/possible trials:
[cRho, cPValue] = corr( ICB1, ICB1pos )

% bootstrap test for global bias:
nSim = 1e6;
nImpossibleTrials = 40; 
sim_avgPup = nan( nSim,1 );
for sim = 1:nSim
    pUp_sim = (1 / nImpossibleTrials) * binornd( nImpossibleTrials, ...
        datasample( ICB1, length(ICB1) )  );
    sim_avgPup(sim) = mean( pUp_sim );
end
avgPup_95CI = quantile( sim_avgPup, [.025, 0.975] )
    
% bootstrap the std:
nSim = 1e5;
%real_avgPup = 0.5; % fair Bernoulli process
real_avgPup = mean( ICB1 ); %Bernoulli process with p = average pUp
real_stdPup = std( ICB1 );
sim_stdPup = std( (1 / nImpossibleTrials) * ...
    binornd( nImpossibleTrials, real_avgPup, length(ICB1), nSim  ) );
sigLevel = sum( sim_stdPup > real_stdPup ) / nSim

% sig. test ICB dist:
nSim = 1e5;
samp_std = nan( nSim,1 );
bino_std = nan( nSim,1 );
for s = 1:nSim
    samp = datasample( ICB1, length(ICB1) );
    samp_std(s) = std( samp );
    samp_mean = mean(samp);
    bino_std(s) = std( (1 / nImpossibleTrials) * binornd( ...
        nImpossibleTrials, samp_mean, length(ICB1), 1 ) );
end
sigLevel = sum( bino_std > samp_std ) / nSim


% Figure 2 tests (differences between means or variance in the first sess):
% Figure S2-2: Also, plot the summary of comparisons:
% Brown-Forsythe test computed by performing ANOVA on the absolute 
% deviations of the data values from the group medians:
figure;
p = vartestn( pMat.Vertical(:,6), timeCell, 'TestType', 'BrownForsythe' )
xtickangle(45); ylim([-.02,1.02]); ylabel('p_{up}^0'); box off;
% one-way ANOVA of ranks:
figure;
[p,~,stats] = kruskalwallis( pMat.Vertical(:,6), timeCell )
%c = multcompare(stats)

% Fig. 3 (Extended data Fig. 3B) tests for differences between means in the
    % first sess - FEEDBACK:
dayUp = behav.feedback.Vertical.day.sess1.dev0.oldResponse.mean( ...
    behav.feedback.Vertical.day.manip == 1 );
dayUpName = cell( size(dayUp) );
dayUpName(:) = {'day Up'};
dayDown = behav.feedback.Vertical.day.sess1.dev0.oldResponse.mean( ...
    behav.feedback.Vertical.day.manip == -1 );
dayDownName = cell( size(dayDown) );
dayDownName(:) = {'day Down'};
monthUp = behav.feedback.Vertical.month.sess1.dev0.oldResponse.mean( ...
    behav.feedback.Vertical.month.manip == 1 );
monthUpName = cell( size(monthUp) );
monthUpName(:) = {'month Up'};
monthDown = behav.feedback.Vertical.month.sess1.dev0.oldResponse.mean( ...
    behav.feedback.Vertical.month.manip == -1 );
monthDownName = cell( size(monthDown) );
monthDownName(:) = {'month Down'};
allFeed1 = [dayUp; dayDown; monthUp; monthDown];
allFeed1Name = [dayUpName; dayDownName; monthUpName; monthDownName];
figure;
[p,~,stats] = kruskalwallis( allFeed1, allFeed1Name )
% compare each group individually to 1/2:
p = signrank( dayUp-.5 )
p = signrank( dayDown-.5 )
p = signrank( monthUp-.5 )
p = signrank( monthDown-.5 )


% FEEDBACK DATA:

% read feedback data:
dat = 2;
dataName = dataNames{dat};
timeNames = dataTimeGroupNames.(dataName);
thisMans = [-1,1];
colMans = [0,0,1; 1,0,0];

% Fig. 5A - feedback - ICB 2nd vs. 3rd sess by delay group:
for task = 1:length(taskNames)
    taskName = taskNames{task};
    for ti = 1:length(timeNames)
        timeName = timeNames{ti};
        figure;
        p2 = behav.(dataName).(taskName).(timeName ...
            ).sess2.dev0.responseCongruent.mean;
        p3 = behav.(dataName).(taskName).(timeName ...
            ).sess3.dev0.responseCongruent.mean;
        man =  behav.(dataName).(taskName).(timeName).manip;
        plot( [0,1], [0,1], 'k', 'lineWidth', 1 ); hold on;
        plot( p2, p3, ...
            'Marker', 'o', 'MarkerSize', 5, ...
            'MarkerFaceColor', 'k', 'MarkerEdgeColor', [1 1 1], ...
            'lineStyle', 'none'); hold on;
        xlabel('p_{Con}^0 session 2');
        ylabel('p_{Con}^0  session 3')
        box off; axis square; xlim([0,1]); ylim([0,1]);
        ggg = gca; ggg.XMinorTick = 'on'; ggg.YMinorTick = 'on'; 
        title([taskName ' - ' timeName]);
    end
end

% Fig. 6A - feedback - ICB 1st vs. 3rd sess by delay group x manip:
for task = 1:length(taskNames)
    taskName = taskNames{task};
    for ti = 1:length(timeNames)
        timeName = timeNames{ti};
        figure;
        p1 = behav.(dataName).(taskName).(timeName ...
            ).sess1.dev0.oldResponse.mean;
        p3 = behav.(dataName).(taskName).(timeName ...
            ).sess3.dev0.oldResponse.mean;
        man =  behav.(dataName).(taskName).(timeName).manip;
        clear plt leg;
        for m = 1:2
            thisMan = thisMans(m);
            colMan = colMans(m,:);
            p1m = p1(man == thisMan);
            p3m = p3(man == thisMan);
            plt(1+2*(m-1)) = plot( p1m, p3m, ...
                'Marker', 'o', 'MarkerSize', 5, ...
                'MarkerFaceColor', colMan, 'MarkerEdgeColor', [1 1 1], ...
                'lineStyle', 'none'); hold on;
            % Orthogonal regression:
            v = pca([p1m p3m]);
            slope = v(2,1)/v(1,1);
            k = mean( p3m ) - slope * mean( p1m );
            plot( [0,1], slope * [0,1] + k, 'Color', [1,1,1], ...
                'lineWidth', 2 ); hold on;
            plt(2+2*(m-1)) = plot( [0,1], slope * [0,1] + k, 'Color', ...
                colMan, 'lineWidth', 1 ); hold on;
            mean_imp = mean( p1m );
            mean_pos = mean( p3m );
            sem_imp = std( p1m ) / sqrt( length(p1m) );
            sem_pos = std( p3m ) / sqrt( length(p3m) );
            [rho, pVal] = corr( p1m, p3m );
            leg{1+2*(m-1)} = ['data: rho = ' num2str(rho) ', p = ' 
                num2str(pVal)];
            leg{2+2*(m-1)} = ['Ortho. reg: slope = ' num2str(slope) ...
                ' inter.=' num2str(k)];
        end
        legend( plt, leg, 'Location','SouthOutside');
        xlabel('ICB session 1');
        ylabel('ICB session 3')
        box off; axis square; xlim([0,1]); ylim([0,1]);
        ggg = gca; ggg.XMinorTick = 'on'; ggg.YMinorTick = 'on'; 
        title([taskName ' - ' timeName]);
    end
end

% Extended Fig. 3A - feedback - ICB distribution in 1st session:
dataName = 'feedback';
timeNames = dataTimeGroupNames.(dataName);
for task = 1:length(taskNames)
    taskName = taskNames{task};
    edges = linspace(0,1,42);
    pUp0FeedSess1 = [];
    for ti = 1:length(timeNames)
        timeName = timeNames{ti};
        pUp0FeedSess1 = [pUp0FeedSess1; ...
            behav.(dataName).(taskName).(timeName ...
            ).sess1.dev0.oldResponse.mean];
    end
    ICB_BL_pdf = histcounts( pUp0FeedSess1, 'binEdges', edges );
    figure;
    bar( 0:(1/40):1, ICB_BL_pdf, 'FaceColor', [.5 .5 .5], 'edgeColor', ...
        'none' ); 
    xlim([-0.025,1.025]); box off; 
    xlabel('{\itp}^0_{{\itup}}'); ylabel('# participants');
    ggg = gca; ggg.XMinorTick = 'on'; ggg.YMinorTick = 'on';
    xticks(0:.25:1); hold on;
end

% TEST: compare ICB std in 1st session of feedback vs. stability
relFields1.stability = 'response';
relFields1.feedback = 'oldResponse';
nSim = 1e6;
for task = 1:length(taskNames)
    taskName = taskNames{task};
    for dat = 1:length(dataNames)
        dataName = dataNames{dat};
        field = relFields1.(dataName);
        timeNames = dataTimeGroupNames.(dataName);
        pChoiceSess1Temp = [];
        for ti = 1:length(timeNames)
            timeName = timeNames{ti};
            pChoiceSess1Temp = [pChoiceSess1Temp; ...
                behav.(dataName).(taskName).(timeName).sess1.dev0.( ...
                field).mean];
        end
        pChoiceSess1.(dataName) = pChoiceSess1Temp;
    end
    % compute real diff in std:
    pStdRealDiff = std( pChoiceSess1.stability ) - std( ...
        pChoiceSess1.feedback );
    pChoiceSess1All = [pChoiceSess1.stability; pChoiceSess1.feedback];
    nStability = length( pChoiceSess1.stability );
    nFeedback = length( pChoiceSess1.feedback );
    % simulate p_std_sess1 for each dataset (stability, feedback):
    pStdSimDiff = nan(nSim,1);
    for s = 1:nSim
        stdStimStability = std( datasample( pChoiceSess1All, ...
            nStability ) );
        stdStimFeedback = std( datasample( pChoiceSess1All, nFeedback ) );
        pStdSimDiff(s) = stdStimStability - stdStimFeedback;
    end
    pVal_pStdStabilityFeedback.(taskName) = ...
        mean( pStdSimDiff >= abs(pStdRealDiff) ) + ...
        mean( pStdSimDiff <= -abs(pStdRealDiff) );
end



%% Test Fig. 6B - bootstap difference in corr(p1,p3) between delay groups:

load('behavioralData.mat');

d1 = behav.feedback.Vertical.day.sess1.dev0.oldResponse.mean;
d3 = behav.feedback.Vertical.day.sess3.dev0.oldResponse.mean;
m1 = behav.feedback.Vertical.month.sess1.dev0.oldResponse.mean;
m3 = behav.feedback.Vertical.month.sess3.dev0.oldResponse.mean;

corrMonth = corr( m3, m1 );
corrDay = corr( d3, d1 );
realCorrDiff = corrMonth - corrDay;

% exact test: Correlation testing via Fisher transformation:
TransCorrMonth = .5 * log( (1 + corrMonth) / (1 - corrMonth) );
TransCorrDay = .5 * log( (1 + corrDay) / (1 - corrDay) );
s = sqrt( ( 1 / ( length(d1) - 3 ) ) + ( 1 / ( length(m1) - 3 ) )  );
pValExact = 1 - normcdf( (TransCorrMonth - TransCorrDay) / s )

% simulate correlation diffference:
nSim = 1e6;
simCorrDiff = nan(nSim,1);
% bootsrap corr each individualy -> calc diff:
simCorrDiff_2 = nan(nSim,1); 
simCorr2_day = nan(nSim,1); 
simCorr2_month = nan(nSim,1); 
% bootsrap from both --> calc diff:
simCorrDiff_1 = nan(nSim,1); 
dm1 = [d1;m1];
dm3 = [d3;m3];

sss = RandStream('mlfg6331_64'); 

for s = 1:nSim
    % bootsrap corr each individualy -> calc diff:
    locD = datasample( sss, 1:length(d1), length(d1) );
    locM = datasample( sss, 1:length(m1), length(m1) );
    simCorr2_day(s) = corr( d3(locD), d1(locD) ); 
    simCorr2_month(s) = corr( m3(locM), m1(locM) ); 
    simCorrDiff_2(s) = simCorr2_month(s) - simCorr2_day(s); 
    
    % bootsrap from both --> calc diff:
    locDM = datasample( sss, 1:length(dm1), length(dm1) );
    simCorrDiff_1(s) = corr( dm3(locDM(1:length(d1))), dm1( ...
        locDM(1:length(d1))) ) - ...
        corr( dm3(locDM(1+length(d1):end)), dm1(locDM(1+length(d1):end)) ); 
end

% bootsrap corr each individualy -> calc diff:
mean( simCorrDiff_2 < 0 ) % nSim = 1e7: withReturn: p=
% bootsrap from both --> calc diff:
mean( simCorrDiff_1 > realCorrDiff ) % nSim = 1e7: withReturn: p=

